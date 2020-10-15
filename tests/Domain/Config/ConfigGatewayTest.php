<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Config\Values\Fake;

class ConfigGatewayTest extends \Argo\Domain\TestCase
{
    protected $configGateway;

    protected function setUp() : void
    {
        parent::setUp();
        $this->configGateway = $this->container->get(ConfigGateway::CLASS);
    }

    public function test() : void
    {
        $fake = $this->configGateway->newValues('fake', (object) ['foo' => 'bar']);
        $this->configGateway->saveValues($fake);

        $config = $this->configGateway->getConfig();
        $this->assertEquals($fake, $config->fake);
    }
}
