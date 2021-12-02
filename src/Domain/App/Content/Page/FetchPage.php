<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Page;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchPage extends App
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec(string $id) : Payload
    {
        $page = $this->content->pages->getItem($id);

        if ($page === null) {
            return Payload::notFound();
        }

        return Payload::found([
            'page' => $page,
            'body' => $this->content->pages->getBody($page),
        ]);
    }
}
