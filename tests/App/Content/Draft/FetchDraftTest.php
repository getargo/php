<?php
declare(strict_types=1);

namespace Argo\App\Content\Draft;

class FetchDraftTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testNotFound() : void
    {
        $payload = $this->invoke('no-such-draft');
        $this->assertNotFound($payload);
    }

    public function testFound() : void
    {
        $addDraft = $this->container->get(AddDraft::CLASS);
        $created = $addDraft('Title Title');
        $relId = $created->getResult()['item']->relId;

        $found = $this->invoke($relId);
        $this->assertFound($found);
        $this->assertEquals(
            $created->getResult()['item'],
            $found->getResult()['draft']
        );
    }
}
