<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Page;

use Argo\Domain\Content\ContentLocator;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class FetchPages extends UseCase
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec() : Payload
    {
        $pages = $this->content->pages->getItems();
        return Payload::found([
            'pages' => $pages,
        ]);
    }
}
