<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Page;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

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
