<?php
declare(strict_types=1);

namespace Argo\Http;

use AutoRoute\AutoRoute;
use AutoRoute\Generator;
use AutoRoute\Router;
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Capsule\Di\Provider;
use SapiRequest;

class HttpProvider implements Provider
{
    public function provide(Definitions $def) : void
    {
        $def->object(SapiRequest::CLASS)
            ->argument('globals', [
                '_GET' => $_GET,
                '_POST' => $_POST,
                '_FILES' => $_FILES,
                '_COOKIE' => $_COOKIE,
                '_SERVER' => $_SERVER,
            ]);

        $def->object(AutoRoute::CLASS)
            ->factory(function (Container $container) {
                $autoRoute = new AutoRoute(
                    'Argo\\Http\\Action',
                    __DIR__ . '/Action'
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
    }
}
