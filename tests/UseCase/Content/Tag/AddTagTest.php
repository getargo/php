<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Tag;

class AddTagTest extends \Argo\UseCase\TestCase
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
        $this->assertInvalid($payload, 'Tag ID uses invalid characters: !@#$');

        $payload = $this->invoke(' general ');
        $this->assertInvalid($payload, "Tag 'general' already exists.");
    }

    public function testCreated() : void
    {
        $payload = $this->invoke('foo');
        $this->assertCreated($payload);
    }
}
