<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Draft;

class TrashDraftTest extends \Argo\UseCase\TestCase
{
    protected $draft;

    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();

        $addDraft = $this->container->get(AddDraft::CLASS);
        $created = $addDraft('Title Title');
        $this->draft = $created->getResult()['item'];
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-draft');
        $this->assertNotFound($payload);
    }

    public function testDeleted() : void
    {
        $payload = $this->invoke($this->draft->relId);

        $this->assertDeleted($payload);

        $actual = $payload->getResult()['item'];
        $this->assertSame($this->draft->relId, $actual->relId);
    }
}
