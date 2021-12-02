<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content;

class PostIndex
{
    static public function getAllFromPosts(array $posts, int $perPage) : array
    {
        $indexes = [];
        $prev = null;
        $chunks = array_chunk($posts, $perPage);

        foreach ($chunks as $i => $chunk) {
            $pageNum = $i + 1;

            $href = ($pageNum === 1)
                ? "/posts/"
                : "/posts/{$pageNum}/";

            $curr = new PostIndex($chunk, $href);

            if ($prev !== null) {
                $curr->setPrev($prev);
                $prev->setNext($curr);
            }

            $indexes[] = $curr;
            $prev = $curr;
        }

        return $indexes;
    }

    protected $posts;

    protected $href;

    protected $prev;

    protected $next;

    protected $title;

    public function __construct(array $posts, string $href)
    {
        $this->posts = $posts;
        $this->href = $href;
    }

    public function __get(string $key)
    {
        return $this->$key;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function setPrev(?PostIndex $prev) : void
    {
        $this->prev = $prev;
    }

    public function setNext(?PostIndex $next) : void
    {
        $this->next = $next;
    }
}
