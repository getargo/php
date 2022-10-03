<?php
declare(strict_types=1);

namespace Argo\App\Content\Draft;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\DateTime;
use Argo\App\Payload;
use Argo\App\App;

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
