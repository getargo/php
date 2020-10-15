<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Post;

class SavePostTest extends \Argo\UseCase\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-post', [], '');
        $this->assertNotFound($payload);
    }

    public function testUpdated() : void
    {
        $payload = $this->invoke(
            '0001/02/03/sample-post',
            [
                'title' => 'New Title',
            ],
            'New body.'
        );
        $this->assertUpdated($payload);
    }
}
