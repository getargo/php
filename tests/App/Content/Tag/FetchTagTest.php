<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Tag;

class FetchTagTest extends \Argo\Domain\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-tag');
        $this->assertNotFound($payload);
    }

    public function testFound() : void
    {
        $payload = $this->invoke('general');
        $this->assertFound($payload);
    }
}
