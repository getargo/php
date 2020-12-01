<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Draft;

class PublishDraftTest extends \Argo\UseCase\TestCase
{
    protected $draft;

    protected $body = 'Post body.';

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
                'title' => '!@#$',
            ],
            $this->body
        );

        $this->assertInvalid($payload, 'Cannot create post URL from draft title');
    }

    public function testCreated() : void
    {
        $now = $this->modDateTimeNow("+10 minutes");

        $payload = $this->invoke(
            $this->draft->relId,
            (array) $this->draft->data,
            $this->body
        );

        $this->assertCreated($payload);
        $actual = $payload->getResult()['item']->getArrayCopy();
        $expect = [
            'prev' => null,
            'next' => null,
            'lastUpdated' => $now,
            'id' => 'post/0001/02/03/title-title',
            'relId' => '0001/02/03/title-title',
            'type' => 'post',
            'href' => '/post/0001/02/03/title-title/',
            'data' => (object) [
                'title' => 'Title Title',
                'author' => 'boshag',
                'tags' => [
                    0 => 'general',
                ],
                'created' => $now,
                'updated' => [
                    0 => $now,
                ],
                'markup' => 'markdown',
                'tags' => [
                    'general'
                ],
            ],
            'postIndexKey' => null,
        ];
        $this->assertEquals($expect, $actual);
    }

    public function testInvalid_postAlreadyExists() : void
    {
        $payload = $this->invoke(
            $this->draft->relId,
            (array) $this->draft->data,
            $this->body
        );

        $this->assertCreated($payload);

        $addDraft = $this->container->get(AddDraft::CLASS);
        $created = $addDraft('Title Title');
        $draft2 = $created->getResult()['item'];

        $payload = $this->invoke(
            $draft2->relId,
            (array) $draft2->data,
            $this->body
        );

        $this->assertInvalid($payload, "A post at '0001/02/03/title-title' already exists.");
    }
}
