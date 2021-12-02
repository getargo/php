<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Page;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

class TrashPage extends App
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
