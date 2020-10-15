<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Draft;

use Argo\Domain\Content\ItemRepository;

class DraftRepository extends ItemRepository
{
    protected function getGlob() : string
    {
        return '_draft/*';
    }
}
