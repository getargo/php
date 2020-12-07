<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft\Publish;

use Argo\Http\Action;
use Argo\App\Content\Draft\PublishDraft;

class PostDraftPublish extends Action
{
    public function __invoke(string $relId)
    {
        $domain = $this->container->new(PublishDraft::CLASS);
        $payload = $domain(
            $relId,
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
            ],
            $this->request->input['body'] ?? ''
        );
        return $this->responder->respond($this->request, $payload);
    }
}
