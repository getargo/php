<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Page;

class PageTest extends \Argo\Domain\TestCase
{
    public function testAssertId() : void
    {
        Page::assertId('foo-bar');
        Page::assertId('foo/bar');
        $this->assertTrue(true);
    }

    /**
     * @dataProvider provideAssertIdException
     */
    public function testAssertIdException(string $id, string $message) : void
    {
        $this->expectInvalidData($message);
        Page::assertId($id);
    }

    public function provideAssertIdException()
    {
        return [
            ['tag', 'Page ID disallowed'],
            ['tags', 'Page ID disallowed'],
            ['post', 'Page ID disallowed'],
            ['posts', 'Page ID disallowed'],
            ['theme', 'Page ID disallowed'],
        ];
    }

    public function testAbsId() : void
    {
        $relId = 'foo';
        $expect = 'foo';
        $actual = Page::absId($relId);
        $this->assertSame($expect, $actual);
    }

    public function testGetItems() : void
    {
        for ($i = 0; $i < 10; $i++) {
            $id = "page-{$i}";
            $data = ['title' => "Title {$i}"];
            $body = "Body {$i}";
            $page = new Page($id, $data);
            $this->content->pages->save($page, $body);
        }

        $actual = $this->content->pages->getItems();
        $this->assertCount(10, $actual);

        $this->assertSame('page-0', reset($actual)->id);
        $this->assertSame('page-9', end($actual)->id);
    }
}
