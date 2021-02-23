<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\App\AppContainerFactory;
use Argo\Domain\Log;
use Argo\Domain\Storage;
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Capsule\Di\Lazy;

class InfraContainerFactory
{
    static public function new() : Container
    {
        $def = static::define();
        return $def->newContainer();
    }

    static protected function define() : Definitions
    {
        $def = new Definitions();

        $def->object(Log::CLASS, Stdlog::CLASS);

        $def->object(Storage::CLASS, Fsio::CLASS)
            ->argument(
                'docroot',
                Lazy::getCall(System::CLASS, 'docroot')
            );

        return $def;
    }
}
