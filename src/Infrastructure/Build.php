<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Argo\Domain\Content\Draft\Draft;
use Argo\Domain\Content\Folio;
use Argo\Domain\Content\Month;
use Argo\Domain\Content\Page\Page;
use Argo\Domain\Content\Post\Post;
use Argo\Domain\Content\Tag\Tag;
use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\View\ViewFactory;
use Throwable;

class Build
{
    protected $storage;

    protected $config;

    protected $content;

    protected $log;

    protected $level;

    protected $view;

    protected $viewFactory;

    protected $folio;

    public function __construct(
        Storage $storage,
        Config $config,
        ConfigGateway $configGateway,
        Log $log,
        string $level,
        ViewFactory $viewFactory,
        Folio $folio
    ) {
        $this->storage = $storage;
        $this->config = $config;
        $this->configGateway = $configGateway;
        $this->log = $log;
        $this->level = $level;
        $this->viewFactory = $viewFactory;
        $this->folio = $folio;
    }

    public function all() : void
    {
        $start = microtime(true);
        $this->theme();
        $this->posts();
        $this->months();
        $this->tags();
        $this->blogrollShtml();
        $this->menuShtml();
        $this->pages();
        $time = number_format(microtime(true) - $start, 2);

        $message = 'Collected folio ('
            . count($this->folio->posts) . ' posts and '
            . count($this->folio->pages) . ' pages) in '
            . $this->folio->time . ' seconds.';

        $this->log($message);
        $this->log("Built site in {$time} seconds.");
        $this->log("Done!");

        $this->config->admin->lastBuild = $this->folio->utc;
        $this->configGateway->saveValues($this->config->admin);
    }

    public function onePost(Post $post) : void
    {
        $post = $this->folio->posts[$post->id];

        // for each tag on this post, rebuild the tag listing
        foreach ($post->tags as $tag) {
            $this->tag($tag);
        }

        // and the shared tags html
        $this->tagsShtml();

        // for the post month, rebuild the month listing
        $ym = substr($post->created, 0, 7);
        $month = $this->folio->months[$ym];
        $this->month($month);

        // and the shared months html
        $this->monthsShtml();

        // if there is a previous month, rebuild its listing
        if ($month->prev !== null) {
            $this->month($month->prev);
        }

        // build this post
        $this->post($post);

        // build the previous post for a "next" link etc.
        if ($post->prev !== null) {
            $this->post($post->prev);
        }

        // build the next post in case the title changed
        if ($post->next !== null) {
            $this->post($post->next);
        }

        //
        // build all the indexes.
        //
        // this is a candidate for optimization:
        //
        // - a newly published post has to build all indexes
        //
        // - an existing post should rebuild only its own index
        //
        $this->postIndexes();
    }

    public function trashedPost(Post $post) : void
    {
        // for each tag on this post, rebuild the tag listing
        foreach ($post->tags as $tag) {
            $this->tag($this->folio->tags[Tag::absId($tag)]);
        }

        // and the shared tags html
        $this->tagsShtml();

        // for the post month, rebuild the month listing ...
        $ym = substr($post->created, 0, 7);
        $month = $this->folio->months[$ym] ?? null;
        if ($month !== null)  {
            $this->month($month);
        } else {
            // unless it was the only remaining post in that month;
            // delete the month listing, and rebuild the listing of
            // all months.
            $sourceId = "posts/month/" . str_replace($ym, '-', '/');
            $this->storage->trash($sourceId);
            $this->months();
        }

        // and the share months html
        $this->monthsShtml();

        // @todo a deleted post only needs to rebuild its own index
        // and all others after that
        $this->postIndexes();
    }

    public function onePage(Page $page) : void
    {
        $page = $this->folio->pages[$page->id];
        $this->page($page);
    }

    protected function postIndexes() : void
    {
        $perPage = $this->config->general->perPage;

        $chunks = array_chunk(
            $this->folio->posts,
            $perPage
        );

        $pages = count($chunks);

        foreach ($chunks as $i => $posts) {
            $this->postIndex($i + 1, $pages, $posts);
        }
    }

    protected function postIndex(int $pageNum, int $pages, array $posts) : void
    {
        $prev = $pageNum === 1
            ? null
            : (object) [
                'title' => 'Newer Posts',
                'href' => ($pageNum === 2
                    ? '/'
                    : '/posts/' . ($pageNum - 1) . '/'
                ),
            ];

        $next = $pageNum === $pages
            ? null
            : (object) [
                'title' => 'Older Posts',
                'href' => '/posts/' . ($pageNum + 1) . '/',
            ];

        $item = (object) [
            'prev' => $prev,
            'next' => $next,
        ];

        $file = ($pageNum == 1)
            ? "/index.html"
            : "/posts/{$pageNum}/index.html";

        $this->write($file, 'index.html', [
            'item' => $item,
            'posts' => $posts,
            'hasAtom' => $pageNum == 1,
            'hasJson' => true,
        ]);

        if ($pageNum === 1) {
            $this->write('/atom.xml', 'atom.xml', [
                'posts' => $posts,
            ]);
        }
    }

    protected function theme() : void
    {
        $path = $this->storage->app('resources/theme/default');

        $name = trim($this->config->theme->name);
        if ($name === '') {
            $name = 'default';
        }

        $dirs = [
            $this->storage->app("resources/theme/default/assets") => "theme/default",
            $this->storage->app("resources/theme/{$name}/assets") => "theme/{$name}",
            $this->storage->path("_theme/default/assets") => "theme/default",
            $this->storage->path("_theme/{$name}/assets") => "theme/{$name}",
            $this->storage->path("_theme/custom/assets") => "theme/custom",
        ];

        foreach ($dirs as $sourceDir => $targetDir) {

            if (! is_dir($sourceDir)) {
                continue;
            }

            $targetDir = $this->storage->forceDir($targetDir);
            $cmd = "cp -rf $sourceDir/* {$targetDir}/";
            $this->log($cmd);
            exec($cmd, $output);
            $this->log($output);
        }
    }

    public function blogrollShtml() : void
    {
        $this->write('/blogroll.shtml', 'blogroll.shtml');
    }

    public function menuShtml() : void
    {
        $this->write('/menu.shtml', 'menu.shtml');
    }

    public function monthsShtml() : void
    {
        $this->write('/posts/months/index.shtml', 'posts/months/index.shtml', [
            'months' => $this->folio->months,
        ]);
    }

    public function tagsShtml() : void
    {
        $this->write('/tags/index.shtml', 'tags/index.shtml', [
            'tags' => $this->folio->tags,
        ]);
    }

    protected function posts() : void
    {
        foreach ($this->folio->posts as $post) {
            $this->post($post);
        }

        $this->postIndexes();
    }

    protected function post(Post $post) : void
    {
        $this->write("{$post->href}/index.html", 'post/index.html', [
            'post' => $post,
            'item' => $post,
            'hasJson' => true,
        ]);

        $this->write("{$post->href}/index.json", 'post/index.json', [
            'post' => $post,
            'item' => $post
        ]);
    }

    public function tags() : void
    {
        foreach ($this->folio->tags as $tag) {
            $this->tag($tag);
        }

        $this->write('/tags/index.html', 'tags/index.html', [
            'tags' => $this->folio->tags,
            'hasJson' => true,
        ]);

        $this->write('/tags/index.json', 'tags/index.json', [
            'tags' => $this->folio->tags,
        ]);

        $this->tagsShtml();
    }

    public function trashedTag(Tag $tag, array $posts) : void
    {
        $this->tags();

        if (empty($posts)) {
            return;
        }

        foreach ($posts as $post) {
            $this->post($post);
        }

        $this->postIndexes();
    }

    protected function tag(Tag $tag) : void
    {
        $this->write("{$tag->href}/index.html", 'tag/index.html', [
            'tag' => $tag,
            'item' => $tag,
            'hasAtom' => true,
            'hasJson' => true,
        ]);

        $this->write("{$tag->href}/index.json", 'tag/index.json', [
            'tag' => $tag,
            'item' => $tag
        ]);

        $this->write("{$tag->href}/atom.xml", 'tag/atom.xml', [
            'tag' => $tag,
            'item' => $tag
        ]);
    }

    protected function months() : void
    {
        foreach ($this->folio->months as $month) {
            $this->month($month);
        }

        $this->write('/posts/months/index.html', 'posts/months/index.html', [
            'months' => $this->folio->months,
            'hasJson' => true,
        ]);

        $this->write('/posts/months/index.json', 'posts/months/index.json', [
            'months' => $this->folio->months,
        ]);

        $this->monthsShtml();
    }

    protected function month(Month $month) : void
    {
        $this->write("{$month->href}/index.html", 'posts/month/index.html', [
            'month' => $month,
            'item' => $month,
            'hasJson' => true,
        ]);

        $this->write("{$month->href}/index.json", 'posts/month/index.json', [
            'month' => $month,
            'item' => $month
        ]);
    }

    protected function pages() : void
    {
        foreach ($this->folio->pages as $page) {
            $this->page($page);
        }
    }

    protected function page(Page $page) : void
    {
        $this->write("{$page->href}/index.html", 'page.html', [
            'page' => $page,
            'item' => $page
        ]);
    }

    protected function drafts() : void
    {
        foreach ($this->folio->drafts as $draft) {
            $this->draft($draft);
        }
    }

    protected function draft(Draft $draft) : void
    {
        $this->write("{$draft->href}/index.html", 'post/index.html', [
            'post' => $draft,
            'item' => $draft
        ]);
    }

    protected function write(string $id, string $template, $data = []) : void
    {
        $data += [
            'config' => $this->config,
            'hasAtom' => false,
            'hasJson' => false,
        ];

        $id = str_replace('//', '/', $id);
        $this->log($id);

        $name = trim($this->config->theme->name ?? '');
        if ($name === '') {
            $name = 'default';
        }

        $view = $this->viewFactory->new([
            $this->storage->path("_theme/custom/templates"),
            $this->storage->path("_theme/{$name}/templates"),
            $this->storage->app("resources/theme/{$name}/templates"),
            $this->storage->app("resources/theme/default/templates"),
        ]);
        $view->setData($data);
        $view->setView($template);

        $isHtml = strrchr($id, '.') === '.html';

        if ($isHtml) {
            $view->setLayout('layout/main');
        }

        // php seems to dump the entire buffer to output if there
        // is an exception thrown within the view. so, this captures
        // the buffer around the view, and closes all of its own
        // buffers regardless of exceptions.
        try {
            $obLevel = ob_get_level();
            ob_start();
            $text = $view();
        } finally {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
        }

        $this->storage->write($id, $text);
    }

    protected function log(/* string|array */ $message) : void
    {
        $level = $this->level;
        $this->log->$level($message);
    }
}
