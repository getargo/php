<?php
declare(strict_types=1);

namespace Argo\App\Content\Post;

class TrashPostTest extends \Argo\App\TestCase
{
    protected $post;

    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-post');
        $this->assertNotFound($payload);
    }

    public function testDeleted() : void
    {
        $payload = $this->invoke('0001/02/03/sample-post');
        $this->assertDeleted($payload);
    }
}
