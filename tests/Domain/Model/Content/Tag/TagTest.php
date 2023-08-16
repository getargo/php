<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Tag;

use Argo\Domain\Model\Content\Post\Post;

class TagTest extends \Argo\Domain\TestCase
{
    public function testAssertId() : void
    {
        Tag::assertId('tag/foo-bar');
        $this->assertTrue(true);
    }

    public function testAssertIdException() : void
    {
        $this->expectInvalidData('Tag ID has invalid characters; use only a-z, 0-9, and dashes');
        Tag::assertId('foo space bar');
    }

    public function testAbsId() : void
    {
        $relId = 'foo-bar';
        $expect = 'tag/foo-bar';
        $actual = Tag::absId($relId);
        $this->assertSame($expect, $actual);
    }

    public function testAttachPost() : void
    {
        $tag = new Tag(
            Tag::absId('foo-bar'),
            ['title' => 'Foo Bar'],
            ''
        );

        $post = new Post(
            Post::absId('0001/02/03/title-title'),
            ['title' => 'Title Title'],
            'Body body body'
        );

        $tag->attachPost($post);

        $this->assertCount(1, $tag->posts);
    }

    public function testSetPrevAndNext() : void
    {
        $foo = new Tag(
            Tag::absId('foo'),
            ['title' => 'Foo Tag'],
            ''
        );

        $bar = new Tag(
            Tag::absId('bar'),
            ['title' => 'Bar Tag'],
            ''
        );

        $baz = new Tag(
            Tag::absId('baz'),
            ['title' => 'Baz Tag'],
            ''
        );

        $foo->setNext($bar);

        $bar->setPrev($foo);
        $bar->setNext($baz);

        $baz->setPrev($foo);

        $this->assertNull($foo->prev);
        $this->assertSame($bar, $foo->next);

        $this->assertSame($foo, $bar->prev);
        $this->assertSame($baz, $bar->next);

        $this->assertSame($foo, $baz->prev);
        $this->assertNull($baz->next);
    }
}
