<?php
declare(strict_types=1);

namespace Argo\Domain\App\Site;

use Argo\Infra\System;
use Argo\Infra\Server;
use Argo\Domain\Payload;
use Argo\Domain\App;

class SwapSite extends App
{
    protected $system;

    protected $server;

    public function __construct(System $system, Server $server)
    {
        $this->system = $system;
        $this->server = $server;
    }

    protected function exec(string $name) : Payload
    {
        $docroot = $this->system->sitesDir() . "/{$name}";

        if (! is_dir($docroot)) {
            return Payload::notFound();
        }

        $this->server->stop($docroot);
        return Payload::success();
    }
}
