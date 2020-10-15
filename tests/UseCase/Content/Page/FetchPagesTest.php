<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Page;

class FetchPagesTest extends \Argo\UseCase\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testFound() : void
    {
        for ($i = 0; $i < 10; $i++) {
            $addPage = $this->container->get(AddPage::CLASS);
            $payload = $addPage("foo-{$i}");
            $this->assertCreated($payload);
        }

        $payload = $this->invoke();
        $this->assertFound($payload);
        $pages = $payload->getResult()['pages'];
        $this->assertCount(10, $pages);

        $i = 0;
        foreach ($pages as $page) {
            $this->assertEquals("foo-{$i}", $page->relId);
            $i ++;
        }
    }
}
