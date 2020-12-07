<?php
declare(strict_types=1);

namespace Argo\App\Content\Tag;

class AddTagTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testInvalid() : void
    {
        $payload = $this->invoke('  ');
        $this->assertInvalid($payload, "Tag name cannot be blank.");

        $payload = $this->invoke('!@#$');
        $this->assertInvalid($payload, 'Tag ID has invalid characters; use only a-z, 0-9, and dashes.');

        $payload = $this->invoke(' general ');
        $this->assertInvalid($payload, "Tag 'general' already exists.");
    }

    public function testCreated() : void
    {
        $payload = $this->invoke('foo');
        $this->assertCreated($payload);
    }
}
