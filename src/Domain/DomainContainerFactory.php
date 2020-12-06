<?php
declare(strict_types=1);

namespace Argo\Domain;

use Capsule\Di\Container;
use Capsule\Di\Definitions;

class DomainContainerFactory
{
    static public function new() : Container
    {
        $def = static::define();
        return $def->newContainer();
    }

    static protected function define() : Definitions
    {
        return new Definitions();
    }
}
