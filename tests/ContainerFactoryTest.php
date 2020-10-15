<?php
declare(strict_types=1);

namespace Argo;

use Argo\Domain\Storage;
use Argo\Infrastructure\Fsio;
use Capsule\Di\Definitions;

class ContainerFactoryTest extends \Argo\TestCase
{
    public function test() : void
    {
        $container = ContainerFactory::new(function (Definitions $def) {
            $def->object(Storage::CLASS, Fsio::CLASS)
                ->argument('docroot', __DIR__ . '/tmp');
        });

        $actual = $container->get(Storage::CLASS);
        $this->assertInstanceOf(Fsio::CLASS, $actual);
    }
}
