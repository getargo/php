<?php
declare(strict_types=1);

namespace Argo;

use Argo\App\AppContainerFactory;
use Argo\Domain\DateTime;
use Argo\Domain\FakeDateTime;
use Argo\Domain\Log;
use Argo\Infra\FakeLog;
use Argo\Infra\FakeServer;
use Argo\Infra\FakeSystem;
use Argo\Infra\Server;
use Argo\Infra\System;
use Capsule\Di\Container;
use Capsule\Di\Definitions;

class TestContainerFactory extends AppContainerFactory
{
    static protected function define() : Definitions
    {
        $def = parent::define();

        $def->object(DateTime::CLASS, FakeDateTime::CLASS);
        $def->object(System::CLASS, FakeSystem::CLASS);
        $def->object(Server::CLASS, FakeServer::CLASS);
        $def->object(Log::CLASS, FakeLog::CLASS);

        return $def;
    }
}
