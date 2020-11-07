<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Post;

use Argo\Domain\Content\Item;
use Argo\Domain\DateTime;
use Argo\Domain\Content\Draft\Draft;
use Argo\Domain\Exception;

class Post extends Item
{
    public static function assertId(string $id) : void
    {
        parent::assertId($id);
        $regex = '/^post\/\d{4}\/\d{2}\/\d{2}\/[a-z0-9-]+$/';
        if (! preg_match($regex, $id)) {
            throw new Exception\InvalidData("Post ID is not valid: {$id}");
        }
    }

    public static function absId(string $relId) : string
    {
        return "post/{$relId}";
    }

    protected $postIndexKey;

    protected $lastUpdated;

    public function __construct(string $id, array $data = [])
    {
        parent::__construct($id, $data);
        $this->lastUpdated = end($this->data->updated);
    }

    public function setPostIndexKey(int $postIndexKey) : void
    {
        $this->postIndexKey = $postIndexKey;
    }
}
