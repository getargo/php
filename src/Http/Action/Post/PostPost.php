<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\Http\Action;
use Argo\UseCase\Content\Post\SavePost;

class PostPost extends Action
{
    public function __invoke(string ...$relId)
    {
        $domain = $this->container->new(SavePost::CLASS);

        $payload = $domain(
            $this->implode($relId),
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? ''
        );

        return $this->responder->respond($this->request, $payload);
    }
}
