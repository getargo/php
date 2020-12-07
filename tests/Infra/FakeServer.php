<?php
declare(strict_types=1);

namespace Argo\Infra;

class FakeServer extends Server
{
    public function start() : void
    {
    }

    public function stop(string $docroot = null) : void
    {
    }
}
