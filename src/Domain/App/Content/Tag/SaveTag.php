<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Tag;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Infra\BuildFactory;
use Argo\Domain\Payload;
use Argo\Domain\App;

class SaveTag extends App
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
