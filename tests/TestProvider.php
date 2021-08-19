<?php
declare(strict_types=1);

namespace Argo;

use Argo\Domain\DateTime;
use Argo\Domain\FakeDateTime;
use Argo\Domain\Log;
use Argo\Infra\FakeLog;
use Argo\Infra\FakeServer;
use Argo\Infra\FakeSystem;
use Argo\Infra\Server;
use Argo\Infra\System;
use Capsule\Di\Definitions;
use Capsule\Di\Provider;

class TestProvider implements Provider
{
    public function provide(Definitions $def) : void
    {
        $def->{DateTime::CLASS}
            ->class(FakeDateTime::CLASS);

        $def->{System::CLASS}
            ->class(FakeSystem::CLASS);

        $def->{Server::CLASS}
            ->class(FakeServer::CLASS);

        $def->{Log::CLASS}
            ->class(FakeLog::CLASS);
    }
}
