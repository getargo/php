<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Tag;

use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Content\Tag\Tag;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class AddTag extends UseCase
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec(string $relId) : Payload
    {
        $relId = trim($relId);

        if ($relId === '') {
            return Payload::invalid([
                'invalid' => "Tag name cannot be blank.",
            ]);
        }

        Tag::assertId($relId);
        $tag = $this->content->tags->getItem($relId);

        if ($tag !== null) {
            return Payload::invalid([
                'invalid' => "Tag '$relId' already exists.",
            ]);
        }

        $tag = new Tag(Tag::absId($relId));
        $this->content->tags->save($tag, '');

        // @todo: build the tag html, shtml, etc.

        return Payload::created(['item' => $tag]);
    }
}
