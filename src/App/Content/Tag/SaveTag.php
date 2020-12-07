<?php
declare(strict_types=1);

namespace Argo\App\Content\Tag;

use Argo\Domain\Content\ContentLocator;
use Argo\Infrastructure\BuildFactory;
use Argo\App\Payload;
use Argo\App\UseCase;

class SaveTag extends UseCase
{
    protected $content;

    public function __construct(
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->content = $content;
        $this->buildFactory = $buildFactory;
    }

    protected function exec(string $relId, array $data, string $body) : Payload
    {
        $tag = $this->content->tags->getItem($relId);

        if ($tag === null) {
            return Payload::notFound();
        }

        $tag->fill($data);
        $this->content->tags->save($tag, $body);

        $this->buildFactory->new()->tags();

        // @todo if the title changed, rebuild all content with that tag

        return Payload::updated(['item' => $tag]);
    }
}
