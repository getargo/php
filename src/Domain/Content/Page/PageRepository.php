<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Page;

use Argo\Domain\Content\ItemRepository;

class PageRepository extends ItemRepository
{
    protected function getGlob() : string
    {
        return '*/argo.json';
    }

    protected function glob() : array
    {
        return $this->recursiveGlob();
    }

    protected function recursiveGlob(string $id = '', array $list = []) : array
    {
        $pattern = trim("{$id}/" . $this->getGlob(), '/');
        $files = $this->storage->glob($pattern);
        foreach ($files as $file) {
            $file = dirname($file);
            $list[] = $file;
            $subId = $this->getIdFromFile($file);
            $list = $this->recursiveGlob($subId, $list);
        }
        return $list;
    }
}
