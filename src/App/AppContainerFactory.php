<?php
declare(strict_types=1);

namespace Argo\App;

use Argo\Infra\InfraContainerFactory;
use Capsule\Di\Definitions;

class AppContainerFactory extends InfraContainerFactory
{
    static protected function define() : Definitions
    {
        $def = parent::define();
        return $def;
    }
}
