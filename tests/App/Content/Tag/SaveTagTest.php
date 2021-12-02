<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Tag;

class SaveTagTest extends \Argo\Domain\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-tag', [], '');
        $this->assertNotFound($payload);
    }

    public function testUpdated() : void
    {
        $payload = $this->invoke(
            'general',
            [
                'title' => 'New Title',
            ],
            'New body.'
        );
        $this->assertUpdated($payload);
    }
}
