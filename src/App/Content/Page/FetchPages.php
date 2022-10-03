<?php
declare(strict_types=1);

namespace Argo\App\Content\Page;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\App;

class FetchPages extends App
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
