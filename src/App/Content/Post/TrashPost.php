<?php
declare(strict_types=1);

namespace Argo\App\Content\Post;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\App;
use Argo\Infra\BuildFactory;

class TrashPost extends App
{
    protected $content;

    public function __construct(
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->content = $content;
        $this->buildFactory = $buildFactory;
    }

    protected function exec(string $relId) : Payload
    {
        $post = $this->content->posts->getItem($relId);

        if ($post === null) {
            return Payload::notFound();
        }

        $this->content->posts->trash($post);
        $this->buildFactory->new()->trashedPost($post);

        return Payload::deleted(['item' => $post]);
    }
}
