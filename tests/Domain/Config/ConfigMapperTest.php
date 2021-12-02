<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Config;

class ConfigMapperTest extends \Argo\Domain\TestCase
{
    protected $config;

    protected function setUp() : void
    {
        parent::setUp();
        $this->config = $this->container->get(ConfigMapper::CLASS);
    }

    public function test() : void
    {
        $fake = $this->config->new('_argo/fake', (object) ['foo' => 'bar']);
        $this->config->save($fake);
        $this->assertEquals($fake, $this->config->fake);
    }
}
