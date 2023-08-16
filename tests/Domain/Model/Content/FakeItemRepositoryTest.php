<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content;

use Argo\Domain\Model\Content\Page\Page;

class FakeItemRepositoryTest extends \Argo\Domain\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->content->fakes = new FakeItemRepository(
            $this->dateTime,
            $this->storage,
            $this->config,
            $this->content
        );
    }

    public function testSaveAndGet() : void
    {
        $id = 'fake/foo';
        $data = ['title' => 'Title Title'];
        $body = 'Body body body';
        $fake = new FakeItem($id, $data);

        $this->content->fakes->save($fake, $body);

        $actual = $this->storage->exists('/fake/foo/argo.json');
        $this->assertTrue($actual);

        $actual = $this->content->fakes->getItem('foo');
        $this->assertEquals($fake, $actual);

        $actual = $this->content->fakes->getItem('nonesuch');
        $this->assertNull($actual);
    }

    public function testSaveWrongType() : void
    {
        $id = 'foo';
        $data = ['title' => 'Title Title'];
        $body = 'Body body body';
        $page = new Page($id, $data);

        $this->expectDomainException("Wrong type:");
        $this->content->fakes->save($page, $body);
    }

    public function testListCounts() : void
    {
        for ($i = 1; $i <= 50; $i++) {
            $id = "fake/foo-{$i}";
            $data = ['title' => "Title {$i}"];
            $body = "Body {$i}";
            $fake = new FakeItem($id, $data);
            $this->content->fakes->save($fake, $body);
        }

        // predicated on config->general->perPage = 10
        list($itemCount, $pageCount) = $this->content->fakes->listCounts();
        $this->assertSame(50, $itemCount);
        $this->assertSame(5, $pageCount);
    }

    public function testGetItems() : void
    {
        for ($i = 1; $i <= 50; $i++) {
            $id = "fake/foo-{$i}";
            $data = ['title' => "Title {$i}"];
            $body = "Body {$i}";
            $fake = new FakeItem($id, $data);
            $this->content->fakes->save($fake, $body);
        }

        $actual = $this->content->fakes->getItems();
        $this->assertCount(50, $actual);

        $actual = $this->content->fakes->getItems(3);
        $this->assertCount(10, $actual);
        $this->assertSame('fake/foo-21', reset($actual)->id);
        $this->assertSame('fake/foo-30', end($actual)->id);
    }

    public function testTrash() : void
    {
        $id = 'fake/foo';
        $data = ['title' => 'Title Title'];
        $body = 'Body body body';
        $fake = new FakeItem($id, $data);

        $this->content->fakes->save($fake, $body);

        $this->content->fakes->trash($fake);
        $this->assertFalse($this->storage->exists('/fake/foo'));
        // $this->assertTrue($this->storage->exists('/_trash/fake/foo'));
    }

    public function testTrashWrongType()
    {
        $id = 'foo';
        $data = ['title' => 'Title Title'];
        $page = new Page($id, $data);

        $this->expectDomainException("Wrong type:");
        $this->content->fakes->trash($page);
    }
}
