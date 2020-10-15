<?php
declare(strict_types=1);

namespace Argo\UseCase\Site;

use Argo\Infrastructure\Sync;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class SyncSite extends UseCase
{
    protected $sync;

    public function __construct(Sync $sync)
    {
        $this->sync = $sync;
    }

    protected function exec() : Payload
    {
        return Payload::processing([
            'callable' => $this->sync,
        ]);
    }
}
