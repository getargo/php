<?php
declare(strict_types=1);

namespace Argo\Domain\App\Site;

use Argo\Domain\Storage;
use Argo\Infra\System;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchSites extends App
{
    protected $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    protected function exec() : Payload
    {
        return Payload::found([
            'sites' => $this->system->sites(),
            'author' => $this->system->whoami(),
        ]);
    }
}
