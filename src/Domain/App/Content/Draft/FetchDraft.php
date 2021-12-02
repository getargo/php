<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Draft;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchDraft extends App
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

        return Payload::found([
            'draft' => $draft,
            'body' => $this->content->drafts->getBody($draft),
        ]);
    }
}
