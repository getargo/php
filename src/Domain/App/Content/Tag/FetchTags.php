<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Tag;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchTags extends App
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
