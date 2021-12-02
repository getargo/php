<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Post;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchPost extends App
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
