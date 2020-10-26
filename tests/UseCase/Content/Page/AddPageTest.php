<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Page;

class AddPageTest extends \Argo\UseCase\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testInvalid() : void
    {
        $payload = $this->invoke('!@#$');
        $this->assertInvalid($payload, 'Page ID has invalid characters; use only a-z, 0-9, and dashes.');

        $payload = $this->invoke('foo/bar/baz/dib');
        $this->assertInvalid(
            $payload,
            "Cannot create page 'foo/bar/baz/dib' without parent page 'foo/bar/baz' first."
        );
    }

    public function testCreated() : void
    {
        $payload = $this->invoke('/foo/');
        $this->assertCreated($payload);
        $actual = $payload->getResult()['item']->getArrayCopy();
        $expect = [
            'id' => 'foo',
            'relId' => 'foo',
            'type' => 'page',
            'href' => '/foo/',
            'data' => (object) [
                'title' => 'Foo',
                'author' => 'boshag',
                'created' => '0001-02-03 12:34:56 UTC',
                'updated' => [
                    0 => '0001-02-03 12:34:56 UTC',
                ],
                'markup' => 'markdown',
            ],
        ];
        $this->assertEquals($expect, $actual);

        $this->modDateTimeNow('+10 minutes');

        $payload = $this->invoke('/foo/bar');
        $this->assertCreated($payload);

        $actual = $payload->getResult()['item']->getArrayCopy();
        $expect = [
            'id' => 'foo/bar',
            'relId' => 'foo/bar',
            'type' => 'page',
            'href' => '/foo/bar/',
            'data' => (object) [
                'title' => 'Foo Bar',
                'author' => 'boshag',
                'created' => '0001-02-03 12:44:56 UTC',
                'updated' => [
                    0 => '0001-02-03 12:44:56 UTC',
                ],
                'markup' => 'markdown',
            ],
        ];
        $this->assertEquals($expect, $actual);
    }

    public function testInvalid_pageAlreadyExists()
    {
        $payload = $this->invoke('/foo/');
        $this->assertCreated($payload);

        $payload = $this->invoke('foo');
        $this->assertInvalid($payload, 'Page foo already exists.');
    }
}
