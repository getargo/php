<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Tag;

use Argo\Domain\Model\Content\ItemRepository;
use Argo\Exception;

class TagRepository extends ItemRepository
{
    protected function getGlob() : string
    {
        return 'tag/*';
    }

    /**
     * @todo blow up on bad relId
     */
    public function adhocs(array $relIds) : void
    {
        foreach ($relIds as $relId) {
            if ($this->getItem($relId) === null) {
                $id = Tag::absId($relId);
                $tag = new Tag($id);
                $this->save($tag, '');
            }
        }
    }

    /**
     * Note that this also converts $post->data->tags from an array of relIds
     * to an array of Tag objects.
     */
    public function getAllFromPosts(array $posts) : array
    {
        $tags = $this->getItems();
        ksort($tags);

        foreach ($posts as $post) {
            foreach ($post->tags as $i => $relId) {
                $id = Tag::absId($relId);
                $tags[$id]->attachPost($post);
                $post->data->tags[$i] = $tags[$id];
            }
        }

        return $tags;
    }
}
