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
        $def->object(DateTime::CLASS, FakeDateTime::CLASS);
        $def->object(System::CLASS, FakeSystem::CLASS);
        $def->object(Server::CLASS, FakeServer::CLASS);
        $def->object(Log::CLASS, FakeLog::CLASS);
    }
}
