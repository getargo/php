<?php
declare(strict_types=1);

namespace Argo\App;

use Argo\Domain\DomainContainerFactory;
use Capsule\Di\Definitions;

class AppContainerFactory extends DomainContainerFactory
{
    static protected function define() : Definitions
    {
        $def = parent::define();
        return $def;
    }
}
