<?php
declare(strict_types=1);

namespace Argo\App\Config;

use Argo\Domain\Json;

class FetchConfigTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound()
    {
        $name = 'no-such-config';
        $payload = $this->invoke($name);
        $this->assertNotFound($payload);
    }

    public function testFound()
    {
        $name = 'general';
        $payload = $this->invoke($name);
        $this->assertFound($payload);
        $result = $payload->getResult();
        $this->assertSame('general', $result['name']);

        $expect = [
            'title' => 'Argo Blog Title',
            'tagline' => 'Argo Blog Tagline',
            'author' => 'boshag',
            'url' => 'http://example.com',
            'timezone' => 'UTC',
            'perPage' => 10,
            'theme' => 'argo/bootstrap4',
        ];

        $this->assertJsonEquals($expect, $result['text']);
    }
}
