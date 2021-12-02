<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Draft;

class AddDraftTest extends \Argo\Domain\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testCreated_withoutTitle() : void
    {
        $payload = $this->invoke('');
        $this->assertCreated($payload);
        $actual = $payload->getResult()['item']->getArrayCopy();
        $expect = [
            'id' => '_draft/00010203T123456',
            'relId' => '00010203T123456',
            'type' => 'draft',
            'href' => '/_draft/00010203T123456/',
            'data' => (object) [
                'title' => 'Untitled',
                'author' => 'boshag',
                'tags' => [
                    0 => 'general',
                ],
                'created' => '0001-02-03 12:34:56 UTC',
                'updated' => [
                    0 => '0001-02-03 12:34:56 UTC',
                ],
                'markup' => 'markdown',
            ],
            'prev' => null,
            'next' => null,
        ];
        $this->assertEquals($expect, $actual);
    }

    public function testCreated_withTitle() : void
    {
        $payload = $this->invoke('Title Title');
        $this->assertCreated($payload);
        $actual = $payload->getResult()['item']->getArrayCopy();
        $expect = [
            'id' => '_draft/00010203T123456',
            'relId' => '00010203T123456',
            'type' => 'draft',
            'href' => '/_draft/00010203T123456/',
            'data' => (object) [
                'title' => 'Title Title',
                'author' => 'boshag',
                'tags' => [
                    0 => 'general',
                ],
                'created' => '0001-02-03 12:34:56 UTC',
                'updated' => [
                    0 => '0001-02-03 12:34:56 UTC',
                ],
                'markup' => 'markdown',
            ],
            'prev' => null,
            'next' => null,
        ];
        $this->assertEquals($expect, $actual);
    }
}
