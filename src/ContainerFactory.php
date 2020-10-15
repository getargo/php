<?php
declare(strict_types=1);

namespace Argo;

use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Argo\Infrastructure\Fsio;
use Argo\Infrastructure\Stdlog;
use Argo\Infrastructure\System;
use AutoRoute\AutoRoute;
use AutoRoute\Generator;
use AutoRoute\Router;
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Capsule\Di\Lazy;
use SapiRequest;

class ContainerFactory
{
    public static function new(callable $redefine = null) : Container
    {
        $def = new Definitions();

        $_SERVER; // needed so that it gets populated into $GLOBALS
        $def->object(SapiRequest::CLASS)
            ->arguments([
                $GLOBALS
            ]);

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

        $def->object(AutoRoute::CLASS)
            ->factory(function (Container $container) {
                $autoRoute = new AutoRoute(
                    'Argo\\Http\\Action',
                    dirname(__DIR__) . '/src/Http/Action'
                );
                return $autoRoute;
            });

        $def->object(Router::CLASS)
            ->factory(function (Container $container) {
                return $container->get(AutoRoute::CLASS)->newRouter();
            });

        $def->object(Generator::CLASS)
            ->factory(function (Container $container) {
                $generator = $container->get(AutoRoute::CLASS)->newGenerator();
                return $generator;
            });

        if ($redefine !== null) {
            $redefine($def);
        }

        return $def->newContainer();
    }
}
