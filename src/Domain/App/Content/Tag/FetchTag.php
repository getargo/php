<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Tag;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchTag extends App
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
