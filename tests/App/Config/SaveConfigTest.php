<?php
declare(strict_types=1);

namespace Argo\App\Config;

use Argo\Domain\Json;

class SaveConfigTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound()
    {
        $name = 'no-such-config';
        $payload = $this->invoke($name, '');
        $this->assertNotFound($payload);
    }

    public function testInvalid()
    {
        $name = 'general';

        $payload = $this->invoke($name, '');
        $this->assertInvalid($payload, 'The config cannot be blank.');

        $payload = $this->invoke($name, '{"foo": xxx}');
        $this->assertInvalid($payload, 'Parse error');
    }

    public function testUpdated()
    {
        $name = 'general';
        $text = '{"foo": "bar"}';
        $payload = $this->invoke($name, $text);
        $this->assertUpdated($payload);

        $item = $payload->getResult()['item'];
        $this->assertSame('config', $item->type);
        $this->assertSame('general', $item->relId);
    }
}
