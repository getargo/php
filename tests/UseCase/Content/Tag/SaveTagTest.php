<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Tag;

class SaveTagTest extends \Argo\UseCase\TestCase
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
