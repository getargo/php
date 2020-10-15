<?php
declare(strict_types=1);

namespace Argo\UseCase\Site;

use Argo\Domain\Storage;
use Argo\Infrastructure\System;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

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
            'docroot' => rtrim($this->system->docroot(), '/'),
            'author' => $this->system->whoami(),
        ]);
    }
}
