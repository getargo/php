<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Tag;

use Argo\Domain\Model\Content\Post\Post;

class TagRepositoryTest extends \Argo\Domain\TestCase
{
    public function testGetItems() : void
    {
        for ($i = 0; $i < 10; $i++) {
            $id = Tag::absId("foo-{$i}");
            $data = ['title' => "Foo {$i}"];
            $tag = new Tag($id, $data);
            $this->content->tags->save($tag, '');
        }

        $actual = $this->content->tags->getItems();
        $this->assertCount(10, $actual);
    }

    public function testAdhocs() : void
    {
        $actual = $this->content->tags->getItems();
        $this->assertEmpty($actual);

        $relIds = ['foo', 'bar', 'baz'];
        $this->content->tags->adhocs($relIds);

        $actual = $this->content->tags->getItems();
        $this->assertCount(3, $actual);

        $this->assertSame('Foo', $actual['tag/foo']->title);
        $this->assertSame('Bar', $actual['tag/bar']->title);
        $this->assertSame('Baz', $actual['tag/baz']->title);
    }

    public function testGetAllFromPosts() : void
    {
        $tags = ['foo', 'bar', 'baz'];
        for ($i = 0; $i < 9; $i++) {
            $id = Post::absId("0001/02/03/title-{$i}");
            $data = [
                'title' => "Title {$i}",
                'tags' => [
                    $tags[$i % 3],
                ],
            ];
            $body = "Body body {$i}";
            $post = new Post($id, $data);
            $this->content->posts->save($post, $body);
        }

        $posts = $this->content->posts->getItems();
        $actual = $this->content->tags->getAllFromPosts($posts);
        $this->assertCount(3, $actual);

        $this->assertSame('Foo', $actual['tag/foo']->title);
        $this->assertSame('Bar', $actual['tag/bar']->title);
        $this->assertSame('Baz', $actual['tag/baz']->title);
    }
}
