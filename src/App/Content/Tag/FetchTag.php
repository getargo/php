<?php
declare(strict_types=1);

namespace Argo\App\Content\Tag;

use Argo\Domain\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\UseCase;

class FetchTag extends UseCase
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec(string $relId) : Payload
    {
        $tag = $this->content->tags->getItem($relId);

        if ($tag === null) {
            return Payload::notFound();
        }

        return Payload::found([
            'tag' => $tag,
            'body' => $this->content->tags->getBody($tag),
        ]);
    }
}
