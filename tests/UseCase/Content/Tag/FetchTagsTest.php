<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Tag;

class FetchTagsTest extends \Argo\UseCase\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function test() : void
    {
        for ($i = 10; $i < 20; $i ++) {
            $addTag = $this->container->get(AddTag::CLASS);
            $payload = $addTag("foo-{$i}");
            $this->assertCreated($payload);
        }

        $payload = $this->invoke();
        $this->assertFound($payload);
        $this->assertCount(11, $payload->getResult()['tags']);
    }
}
