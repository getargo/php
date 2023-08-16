<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Storage;

class Folio
{
    static public function new(Storage $storage, ConfigMapper $config, ContentLocator $content, DateTime $dateTime) : Folio
    {
        $start = microtime(true);
        $folio = new Folio();

        $folio->config = (object) [];
        $files = $storage->glob('_argo/*.json');

        foreach ($files as $file) {
            $file = basename($file);
            $name = substr($file, 0, strpos(basename($file), '.'));
            $folio->config->$name = $config->$name;
        }

        $folio->config->theme = $config->theme;

        $folio->drafts = $content->drafts->getItems();
        $folio->posts = $content->posts->getItems();
        $folio->postIndexes = PostIndex::getAllFromPosts($folio->posts, $folio->config->general->perPage);
        $folio->tags = $content->tags->getAllFromPosts($folio->posts);
        $folio->months = Month::getAllFromPosts($folio->posts, $dateTime);
        $folio->pages = $content->pages->getItems();
        $folio->utc = $dateTime->utc();
        $folio->time = number_format(microtime(true) - $start, 2);

        $penders = [];
        $theme = $folio->config->general->theme;
        $dir = "_theme/custom/{$theme}/templates/penders";
        foreach ($storage->glob("$dir/*/*.qiq.php") as $path) {
            $parts = explode('/', $path);
            $name = array_pop($parts);
            $type = array_pop($parts);
            $penders[$type][] = substr($name, 0, -8);
        }
        $folio->penders = $penders;

        return $folio;
    }

    protected $config;

    protected $drafts;

    protected $posts;

    protected $postIndexes;

    protected $tags;

    protected $months;

    protected $pages;

    protected $utc;

    protected $time;

    protected $penders;

    final private function __construct()
    {
    }

    public function __get(string $key)
    {
        return $this->$key;
    }
}
