<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Page;

class PageRepositoryTest extends \Argo\Domain\TestCase
{
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
