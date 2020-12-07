<?php
declare(strict_types=1);

namespace Argo\App\Content\Post;

use Argo\Domain\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\UseCase;

class FetchPost extends UseCase
{
    protected $content;

    public function __construct(ContentLocator $content)
    {
        $this->content = $content;
    }

    protected function exec(string $relId) : Payload
    {
        $post = $this->content->posts->getItem($relId);

        if ($post === null) {
            return Payload::notFound();
        }

        return Payload::found([
            'post' => $post,
            'body' => $this->content->posts->getBody($post),
        ]);
    }
}
