<?php
declare(strict_types=1);

namespace Argo\Domain\App\Site;

use Argo\Infra\Sync;
use Argo\Domain\Payload;
use Argo\Domain\App;

class SyncSite extends App
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
