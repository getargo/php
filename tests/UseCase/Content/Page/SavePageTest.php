<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Page;

class SavePageTest extends \Argo\UseCase\TestCase
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
        $payload = $this->invoke('no-such-page', [], '');
        $this->assertNotFound($payload);
    }

    public function testUpdated() : void
    {
        $id = 'foo';
        $data = ['title' => 'New Title'];
        $body = 'New body.';

        $payload = $this->invoke($id, $data, $body);
        $this->assertUpdated($payload);
    }
}
