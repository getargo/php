<?php
declare(strict_types=1);

namespace Argo\App\Content\Page;

use Argo\Domain\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\UseCase;

class TrashPage extends UseCase
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

        $this->content->pages->trash($page);

        return Payload::deleted(['item' => $page]);
    }
}
