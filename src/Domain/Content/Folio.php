<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Content\ContentLocator;
use Argo\Domain\DateTime;

class Folio
{
    static public function new(ContentLocator $content, DateTime $dateTime) : Folio
    {
        $start = microtime(true);
        $folio = new Folio();
        $folio->drafts = $content->drafts->getItems();
        $folio->posts = $content->posts->getItems();
        $folio->tags = $content->tags->getAllFromPosts($folio->posts);
        $folio->months = Month::getAllFromPosts($folio->posts, $dateTime);
        $folio->pages = $content->pages->getItems();
        $folio->utc = $dateTime->utc();
        $folio->time = number_format(microtime(true) - $start, 2);
        return $folio;
    }

    protected $drafts;

    protected $posts;

    protected $tags;

    protected $months;

    protected $pages;

    protected $utc;

    protected $time;

    final private function __construct()
    {
    }

    public function __get(string $key)
    {
        return $this->$key;
    }
}
