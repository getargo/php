<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

class FakeServer extends Server
{
    public function start() : void
    {
    }

    public function stop(string $docroot = null) : void
    {
    }
}
