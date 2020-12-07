<?php
declare(strict_types=1);

namespace Argo\Domain;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Capsule\Di\Container;
use Capsule\Di\Definitions;

class DomainContainerFactory
{
    static public function new() : Container
    {
        $def = static::define();

        $def->object(Config::CLASS)
            ->factory(function (Container $container) {
                $configGateway = $container->get(ConfigGateway::CLASS);
                return $configGateway->getConfig();
            });

        return $def->newContainer();
    }

    static protected function define() : Definitions
    {
        return new Definitions();
    }
}
