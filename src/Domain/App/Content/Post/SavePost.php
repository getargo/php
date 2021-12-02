<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Post;

use Argo\Domain\Model\DateTime;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Infra\BuildFactory;
use Argo\Domain\Payload;
use Argo\Domain\App;

class SavePost extends App
{
    protected $content;

    protected $buildFactory;

    public function __construct(
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->content = $content;
        $this->buildFactory = $buildFactory;
    }

    protected function exec(string $relId, array $data, string $body) : Payload
    {
        $post = $this->content->posts->getItem($relId);

        if ($post === null) {
            return Payload::notFound();
        }

        $post->fill($data);
        $this->content->posts->save($post, $body);
        $this->buildFactory->new()->onePost($post);

        return Payload::updated(['item' => $post]);
    }
}
