<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content;

class FakeItemRepository extends ItemRepository
{
    protected function getGlob() : string
    {
        return 'fake/*';
    }

    protected function glob() : array
    {
        $items = parent::glob();
        natsort($items);
        return array_values($items);
    }
}
