<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Page;

use Argo\Domain\Content\Item;
use Argo\Domain\Exception;

class Page extends Item
{
    public static function assertId(string $id) : void
    {
        parent::assertId($id);

        $invalid = ['author', 'authors', 'post', 'posts', 'tag', 'tags', 'theme'];
        if (in_array($id, $invalid)) {
            throw new Exception\InvalidData("Page ID disallowed: {$id}");
        }
    }

    public static function absId(string $relId) : string
    {
        return $relId;
    }

    protected function getRelId() : string
    {
        return $this->id;
    }
}
