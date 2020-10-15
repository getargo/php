<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Post;

use Argo\Domain\Content\Draft\Draft;

class PostTest extends \Argo\Domain\TestCase
{
    public function testAssertId() : void
    {
        Post::assertId('post/0001/01/01/foo-bar-1');
        $this->assertTrue(true);
    }

    public function testAssertIdException() : void
    {
        $this->expectInvalidData('Post ID is not valid');
        Post::assertId('foo');
    }

    public function testAbsId() : void
    {
        $relId = '0001/01/01/foo-bar-1';
        $expect = 'post/0001/01/01/foo-bar-1';
        $actual = Post::absId($relId);
        $this->assertSame($expect, $actual);
    }
}
