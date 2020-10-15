<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Page;

use Argo\Domain\Content\ContentLocator;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class FetchPage extends UseCase
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
