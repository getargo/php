<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Exception;

class FakeItem extends Item
{
    public static function assertId(string $id) : void
    {
        parent::assertId($id);
        $regex = '/^fake\/[a-z0-9-]+$/';
        if (! preg_match($regex, $id)) {
            throw new Exception\InvalidData("FakeItem ID is not valid: {$id}");
        }
    }

    static public function absId(string $relId) : string
    {
        return "fake/{$relId}";
    }
}
