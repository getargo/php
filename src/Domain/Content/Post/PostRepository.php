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
        $perPage = $this->config->general->perPage;
        $metas = parent::getItems($pageNum);

        uasort($metas, function (Post $a, Post $b) {
            return $b->created <=> $a->created;
        });

        return $metas;
    }

    public function save(Item $post, string $body = null) : void
    {
        parent::save($post, $body);
        $this->content->tags->adhocs($post->tags);
    }
}
