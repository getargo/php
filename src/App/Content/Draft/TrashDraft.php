<?php
declare(strict_types=1);

namespace Argo\App\Content\Draft;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\App;

class TrashDraft extends App
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec(string $relId) : Payload
    {
        $draft = $this->content->drafts->getItem($relId);

        if ($draft === null) {
            return Payload::notFound();
        }

        $this->content->drafts->trash($draft);

        return Payload::deleted(['item' => $draft]);
    }
}
