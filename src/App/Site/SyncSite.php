<?php
declare(strict_types=1);

namespace Argo\App\Site;

use Argo\Infra\Sync;
use Argo\App\Payload;
use Argo\App\App;

class SyncSite extends App
{
    protected $sync;

    public function __construct(Sync $sync)
    {
        $this->sync = $sync;
    }

    protected function exec() : Payload
    {
        return Payload::accepted([
            'callable' => $this->sync,
        ]);
    }
}
