<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Draft;

use Argo\Domain\Content\ContentLocator;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class TrashDraft extends UseCase
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
