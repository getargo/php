<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Config\Values\Fake;

class ConfigTest extends \Argo\Domain\TestCase
{
    public function test__magic()
    {
        $fake = new Fake();

        $config = new Config([
            'fake' => $fake,
        ]);

        $this->assertSame($fake, $config->fake);
        $this->assertTrue(isset($config->fake));
        unset($config->fake);
        $this->assertFalse(isset($config->fake));
    }

    public function testAssertValues()
    {
        $this->expectDomainException('Not an instance of Argo\Domain\Config\Values\Values');
        $config = new Config([
            'fake' => null,
        ]);
    }
}
