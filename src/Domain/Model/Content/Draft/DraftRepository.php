<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Draft;

use Argo\Domain\Model\Content\ItemRepository;

class DraftRepository extends ItemRepository
{
    protected function getGlob() : string
    {
        return '_draft/*';
    }
}
