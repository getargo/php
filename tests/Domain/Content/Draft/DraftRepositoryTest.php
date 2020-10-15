<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Draft;

use Argo\Domain\DateTime;
use Argo\Domain\Content\Post\Post;

class DraftRepositoryTest extends \Argo\Domain\TestCase
{
    public function testGetItems() : void
    {
        for ($i = 10; $i < 20; $i++) {
            $id = Draft::absId("00010203T0405{$i}");
            $data = ['title' => "Title {$i}"];
            $body = "Body {$i}";
            $draft = new Draft($id, $data);
            $this->content->drafts->save($draft, $body);
        }

        $actual = $this->content->drafts->getItems();
        $this->assertCount(10, $actual);
    }
}
