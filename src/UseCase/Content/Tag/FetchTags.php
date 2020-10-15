<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Tag;

use Argo\Domain\Content\ContentLocator;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class FetchTags extends UseCase
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec() : Payload
    {
        return Payload::found([
            'tags' => $this->content->tags->getItems()
        ]);
    }
}
