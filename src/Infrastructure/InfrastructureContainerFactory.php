<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Argo\Domain\DomainContainerFactory;
use Argo\Domain\Log;
use Argo\Domain\Storage;
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Capsule\Di\Lazy;

class InfrastructureContainerFactory extends DomainContainerFactory
{
    static protected function define() : Definitions
    {
        $def = parent::define();

        $def->object(Log::CLASS, Stdlog::CLASS);

        $def->object(Storage::CLASS, Fsio::CLASS)
            ->argument(
                'docroot',
                Lazy::getCall(System::CLASS, 'docroot')
            );

        $def->object(Config::CLASS)
            ->factory(function (Container $container) {
                $configGateway = $container->get(ConfigGateway::CLASS);
                return $configGateway->getConfig();
            });

        return $def;
    }
}
