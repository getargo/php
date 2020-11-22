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
use Argo\Domain\Content\PostIndex;
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
        $this->menuShtml();
        $this->blogrollShtml();
        $this->featuredShtml();
        $this->index();
        $this->postIndexes();
        $this->posts();
        $this->months();
        $this->tags();
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

    public function onePost(Post $post, bool $new = true) : void
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

        // a newly published post has to build all indexes
        if ($new) {
            $this->index();
            $this->postIndexes();
            return;
        }

        // an existing post should rebuild only its own index, including
        // the home index if it is the first one
        $i = $post->postIndexKey;
        if ($i === 0) {
            $this->index();
        }

        $postIndex = $this->folio->postIndexes[$i];
        $pageNum = $i + 1;
        $this->postIndex($postIndex, "Posts ({$pageNum})", $pageNum === 1);
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
            // ... unless it was the only remaining post in that month;
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
        $this->index();
        $this->postIndexes();
    }

    public function onePage(Page $page) : void
    {
        $page = $this->folio->pages[$page->id];
        $this->page($page);
    }

    protected function postIndexes() : void
    {
        foreach ($this->folio->postIndexes as $i => $postIndex) {
            $pageNum = $i + 1;
            $this->postIndex($postIndex, "Posts ({$pageNum})", $pageNum === 1);
        }
    }

    protected function postIndex(PostIndex $postIndex, string $title, bool $hasAtom) : void
    {
        $postIndex->setTitle($title);

        if ($postIndex->prev !== null) {
            $postIndex->prev->setTitle('Newer Posts');
        }

        if ($postIndex->next !== null) {
            $postIndex->next->setTitle('Older Posts');
        }

        $this->write("{$postIndex->href}/index.html", 'posts/index.html', [
            'item' => $postIndex,
            'postIndex' => $postIndex,
            'hasAtom' => $hasAtom,
            'hasJson' => true,
        ]);

        if ($hasAtom) {
            $this->write('/posts/atom.xml', 'atom.xml', [
                'postIndex' => $postIndex,
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
            $this->storage->path("_theme/{$name}-custom/assets") => "theme/{$name}-custom",
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

    public function featuredShtml() : void
    {
        $this->write('/featured.shtml', 'featured.shtml');
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

    protected function index() : void
    {
        $postIndex = new PostIndex($this->folio->postIndexes[0]->posts, '/');
        $postIndex->setTitle('Home');

        if (isset($this->folio->postIndexes[1])) {
            $postIndex->setNext($this->folio->postIndexes[1]);
            $postIndex->next->setTitle('Older Posts');
        }

        $this->write('/index.html', 'index.html', [
            'item' => $postIndex,
            'postIndex' => $postIndex,
            'hasAtom' => true,
            'hasJson' => true,
        ]);

        $this->write('/atom.xml', 'atom.xml', [
            'postIndex' => $postIndex,
        ]);
    }

    protected function posts() : void
    {
        foreach ($this->folio->posts as $post) {
            $this->post($post);
        }
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

        $this->index();
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
            $this->storage->path("_theme/{$name}-custom/templates"),
            $this->storage->path("_theme/{$name}/templates"),
            $this->storage->app("resources/theme/{$name}/templates"),
            $this->storage->app("resources/theme/default/templates"),
        ]);
        $view->setData($data);
        $view->setView($template);

        $isHtml = strrchr($id, '.') === '.html';

        if ($isHtml) {
            $view->setLayout('layout/html');
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
