<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\DateTime;
use Argo\Domain\Storage;

class Folio
{
    static public function new(Storage $storage, Config $config, ContentLocator $content, DateTime $dateTime) : Folio
    {
        $start = microtime(true);
        $folio = new Folio();
        $folio->config = $config;
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
        $dir = "_theme/{$theme}-custom/templates/penders";
        foreach ($storage->glob("$dir/*/*.php") as $path) {
            $parts = explode('/', $path);
            $name = array_pop($parts);
            $type = array_pop($parts);
            $penders[$type][] = substr($name, 0, -4);
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
