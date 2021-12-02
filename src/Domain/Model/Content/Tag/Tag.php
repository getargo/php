<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Tag;

use Argo\Domain\Model\Content\Item;
use Argo\Domain\Model\Content\Post\Post;
use Argo\Domain\Exception\InvalidData;

class Tag extends Item
{
    public static function absId(string $relId) : string
    {
        return "tag/{$relId}";
    }

    protected $posts = [];

    protected function fixData(array $data) : array
    {
        $data = parent::fixData($data);
        unset($data['tags']);
        return $data;
    }

    public function fill(array $data) : void
    {
        parent::fill($data);
        $this->data->title = $this->data->title ?? self::titleize($this->relId);
    }

    public function attachPost(Post $post)
    {
        $this->posts[] = $post;
    }
}
