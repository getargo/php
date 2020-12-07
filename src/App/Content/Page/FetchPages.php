<?php
declare(strict_types=1);

namespace Argo\App\Content\Page;

use Argo\Domain\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\UseCase;

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
