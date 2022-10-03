<?php
declare(strict_types=1);

namespace Argo\App\Content\Page;

class TrashPageTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();

        $addPage = $this->container->get(AddPage::CLASS);
        $payload = $addPage('foo');
        $this->assertCreated($payload);
        $this->page = $payload->getResult()['item'];
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-page');
        $this->assertNotFound($payload);
    }

    public function testDeleted() : void
    {
        $payload = $this->invoke('foo');
        $this->assertDeleted($payload);
    }
}
