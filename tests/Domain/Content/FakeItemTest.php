<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Json;

class FakeItemTest extends \Argo\Domain\TestCase
{
    public function testAssertId() : void
    {
        $this->expectNotToPerformAssertions();
        FakeItem::assertId('fake/foo');
    }

    /**
     * @dataProvider provideAssertIdExceptions
     */
    public function testAssertIdExceptions(string $id, string $message) : void
    {
        $this->expectInvalidData($message);
        FakeItem::assertId($id);
    }

    public function provideAssertIdExceptions() : array
    {
        return [
            ['', 'FakeItem ID cannot be blank'],
            ['foo_bar/baz.dib', 'FakeItem ID has invalid characters; use only a-z, 0-9, and dashes'],
            ['/foo/bar/', 'FakeItem ID cannot begin or end with slashes'],
            ['foo//bar', 'FakeItem ID cannot have contiguous slashes'],
            ['fake/foo/bar', 'FakeItem ID is not valid'],
        ];
    }

    public function testNew() : void
    {
        $data = ['title' => 'Title Title'];
        $fake = new FakeItem('fake/foo', $data);

        $this->assertSame('fake/foo', $fake->id);
        $this->assertSame('foo', $fake->relId);
        $this->assertSame('/fake/foo/', $fake->href);
        $expect = (object) ($data + [
            'author' => null,
            'created' => null,
            'updated' => [],
            'markup' => 'markdown',
            'tags' => [],
        ]);
        $this->assertEquals($expect, $fake->data);
    }

    protected function text(array $data, string $body) : string
    {
        return "```\n"
            . Json::encode($data)
            . "\n```\n\n"
            . trim($body)
            . "\n";
    }

    public function testNormalize() : void
    {
        $this->assertSame('foo-bar-baz-dib-gir', FakeItem::normalize("Foo Bar. Baz, dib GIR"));
    }

    public function testTitleize() : void
    {
        $this->assertSame('Foo Bar Baz Dib Gir', FakeItem::titleize('foo-bar-baz-dib-gir'));
    }

    public function test__get() : void
    {
        $fake = new FakeItem(
            'fake/foo',
            ['title' => 'Title Title'],
            'Body body body'
        );

        $this->assertSame('fake/foo', $fake->id);
        $this->assertSame('Title Title', $fake->title);

        $this->expectDomainException('Cannot get $nonesuch on content object.');
        $fake->nonesuch;
    }

    public function test__set() : void
    {
        $fake = new FakeItem(
            'fake/foo',
            ['title' => 'Title Title'],
            'Body body body'
        );

        $this->expectDomainException('Cannot set $id on content object.');
        $fake->id = null;
    }

    public function test__isset() : void
    {
        $fake = new FakeItem(
            'fake/foo',
            ['title' => 'Title Title'],
            'Body body body'
        );

        $this->assertTrue(isset($fake->title));
        $this->assertFalse(isset($fake->author));
        $this->assertFalse(isset($fake->nonesuch));
    }

    public function test__unset() : void
    {
        $fake = new FakeItem(
            'fake/foo',
            ['title' => 'Title Title'],
            'Body body body'
        );

        $this->expectDomainException('Cannot unset $id on content object.');
        unset($fake->id);
    }

    public function testFill() : void
    {
        $fake = new FakeItem('fake/foo');
        $this->assertSame('fake/foo', $fake->id);
        $this->assertSame('foo', $fake->relId);
        $this->assertSame('/fake/foo/', $fake->href);
        $data = [
            'title' => null,
            'author' => null,
            'created' => null,
            'updated' => [],
            'markup' => 'markdown',
            'tags' => [],
        ];
        $this->assertEquals((object) $data, $fake->data);

        $data = [
            'title' => 'Title Title',
            'author' => 'boshag',
            'tags' => 'foo, bar, baz'
        ];
        $fake->fill($data);
        $this->assertSame('Title Title', $fake->title);
        $this->assertSame('boshag', $fake->author);
        $this->assertEquals(['foo', 'bar', 'baz'], $fake->tags);
    }

    public function testFillWithInvalidAuthor() : void
    {
        $fake = new FakeItem('fake/foo');
        $data = [
            'author' => '!!!',
        ];
        $body = 'Body body body';

        $this->expectInvalidData('Author has invalid characters; use only a-z, 0-9, and dashes.');
        $fake->fill($data, $body);
    }

    public function testFillWithInvalidTag() : void
    {
        $fake = new FakeItem('fake/foo');
        $data = [
            'tags' => 'foo, bar baz ',
        ];

        $this->expectInvalidData("Tag 'bar baz' has invalid characters; use only a-z, 0-9, and dashes.");
        $fake->fill($data);
    }

    public function testJsonSerialize() : void
    {
        $data = ['title' => 'Title Title'];
        $fake = new FakeItem('fake/foo', $data);

        $expect = [
            'href' => '/fake/foo/',
            'relId' => 'foo',
            'title' => 'Title Title',
            'author' => null,
            'tags' => [],
            'created' => null,
            'updated' => [],
            'markup' => 'markdown',
        ];
        $actual = json_decode(json_encode($fake), true);
        $this->assertSame($expect, $actual);
    }

    public function testToJson() : void
    {
        $data = ['title' => 'Title Title'];
        $body = "Body body body";
        $fake = new FakeItem('fake/foo', $data, $body);

        $expect = [
            'href' => '/fake/foo/',
            'relId' => 'foo',
            'title' => 'Title Title',
            'author' => null,
            'tags' => [],
            'created' => null,
            'updated' => [],
            'markup' => 'markdown',
            'foo' => 'bar',
        ];

        $actual = json_decode($fake->toJson(['foo' => 'bar']), true);
        $this->assertSame($expect, $actual);
    }
}
