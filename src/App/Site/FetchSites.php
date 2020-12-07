<?php
declare(strict_types=1);

namespace Argo\App\Site;

use Argo\Domain\Storage;
use Argo\Infra\System;
use Argo\App\Payload;
use Argo\App\UseCase;

class FetchSites extends UseCase
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
