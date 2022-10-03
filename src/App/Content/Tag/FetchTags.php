<?php
declare(strict_types=1);

namespace Argo\App\Content\Tag;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\App;

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
