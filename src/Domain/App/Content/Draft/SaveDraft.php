<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Draft;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Payload;
use Argo\Domain\App;

class SaveDraft extends App
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
