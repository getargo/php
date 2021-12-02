<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Draft;

class SaveDraftTest extends \Argo\Domain\App\TestCase
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
        $payload = $this->invoke('no-such-draft', [], '');
        $this->assertNotFound($payload);
    }

    public function testInvalid() : void
    {
        $payload = $this->invoke(
            $this->draft->relId,
            [
                'tags' => 'foo bar',
            ],
            'New body.'
        );

        $this->assertInvalid($payload);
    }

    public function testUpdated() : void
    {
        $payload = $this->invoke(
            $this->draft->relId,
            [
                'title' => 'New Title!',
            ],
            'New body.'
        );

        $this->assertUpdated($payload);

        $actual = $payload->getResult()['item'];
        $this->assertSame('New Title!', $actual->title);
    }
}
