<?php
declare(strict_types=1);

namespace Argo\App;

use Argo\Infrastructure\InfrastructureContainerFactory;
use Capsule\Di\Definitions;

class AppContainerFactory extends InfrastructureContainerFactory
{
    static protected function define() : Definitions
    {
        $def = parent::define();
        return $def;
    }
}
