<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Draft;

use Argo\Domain\Model\Content\Item;
use Argo\Domain\Exception;

class Draft extends Item
{
    public static function assertId(string $id) : void
    {
        if (! preg_match('/^_draft\/\d{8}T\d{6}$/', $id)) {
            throw new Exception\InvalidData("Draft ID is not valid: {$id}");
        }
    }

    public static function absId(string $relId) : string
    {
        return "_draft/{$relId}";
    }
}
