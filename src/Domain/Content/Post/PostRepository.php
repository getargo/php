<?php
declare(strict_types=1);

namespace Argo\Domain\Content\Post;

use Argo\Date;
use Argo\Domain\Content\Item;
use Argo\Domain\Content\ItemRepository;

class PostRepository extends ItemRepository
{
    protected function getGlob() : string
    {
        return 'post/[0-9][0-9][0-9][0-9]/[0-9][0-9]/[0-9][0-9]/*';
    }

    protected function glob() : array
    {
        $glob = parent::glob();
        rsort($glob);
        return $glob;
    }

    public function getItems(?int $pageNum = null) : array
    {
        $items = parent::getItems($pageNum);

        uasort($items, function (Post $a, Post $b) {
            return $b->created <=> $a->created;
        });

        if ($pageNum === null) {
            foreach ($items as $item) {
                $item->setPostIndexKey($pageNum - 1);
            }
        } else {
            $i = 0;
            $perPage = $this->config->general->perPage;

            foreach ($items as $item) {
                $item->setPostIndexKey((int) ($i / $perPage));
                $i += 1;
            }
        }

        return $items;
    }

    public function save(Item $post, string $body = null) : void
    {
        parent::save($post, $body);
        $this->content->tags->adhocs($post->tags);
    }
}
