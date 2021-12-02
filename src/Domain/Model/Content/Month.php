<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content;

use Argo\Domain\Model\Content\Post\Post;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Json;
use JsonSerializable;

class Month implements JsonSerializable
{
    public static function getAllFromPosts(array $posts, DateTime $dateTime) : array
    {
        $months = [];

        foreach ($posts as $post) {
            $ym = str_replace('/', '-', substr($post->relId, 0, 7));
            if (! isset($months[$ym])) {
                $months[$ym] = new Month($ym, $dateTime->month($ym));
            }
            $months[$ym]->attachPost($post);
        }

        $list = array_values($months);
        foreach ($list as $i => $month) {
            $month->setPrev($list[$i - 1] ?? null);
            $month->setNext($list[$i + 1] ?? null);
        }

        return $months;
    }

    protected $href;

    protected $title;

    protected $posts = [];

    protected $prev;

    protected $next;

    public function __construct(string $ym, string $title)
    {
        $this->href = '/posts/month/' . str_replace('-', '/', $ym) . '/';
        $this->title = $title;
    }

    public function __get(string $key)
    {
        return $this->$key;
    }

    public function attachPost(Post $post) : void
    {
        $this->posts[] = $post;
    }

    public function setPrev(?Month $prev) : void
    {
        $this->prev = $prev;
    }

    public function setNext(?Month $next) : void
    {
        $this->next = $next;
    }

    public function jsonSerialize() : mixed
    {
        return [
            'href' => $this->href,
            'title' => $this->title,
            'count' => count($this->posts),
        ];
    }

    public function toJson(array $extra = []) : string
    {
        $encoded = Json::encode($this);
        $decoded = Json::decode($encoded, true);
        return Json::encode($decoded + $extra);
    }
}
