<?php
declare(strict_types=1);

namespace Argo;

use Argo\Domain\DateTime;
use Argo\Domain\FakeDateTime;
use Argo\Domain\Log;
use Argo\Infrastructure\FakeLog;
use Argo\Infrastructure\FakeServer;
use Argo\Infrastructure\FakeSystem;
use Argo\Infrastructure\InfrastructureContainerFactory;
use Argo\Infrastructure\Server;
use Argo\Infrastructure\System;
use Capsule\Di\Container;
use Capsule\Di\Definitions;

class TestContainerFactory extends InfrastructureContainerFactory
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
