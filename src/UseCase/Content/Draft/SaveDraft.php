<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Draft;

use Argo\Domain\Content\ContentLocator;
use Argo\Domain\DateTime;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class SaveDraft extends UseCase
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec(
        string $relId,
        array $data,
        string $body
    ) : Payload
    {
        $draft = $this->content->drafts->getItem($relId);

        if ($draft === null) {
            return Payload::notFound();
        }

        $draft->fill($data);
        $this->content->drafts->save($draft, $body);

        return Payload::updated(['item' => $draft]);
    }
}
