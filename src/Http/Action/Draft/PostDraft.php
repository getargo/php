<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\Http\Action;
use Argo\UseCase\Content\Draft\SaveDraft;

/**
 * this should probably be `PATCH /draft/$relId`
 */
class PostDraft extends Action
{
    public function __invoke(string $relId)
    {
        $domain = $this->container->new(SaveDraft::CLASS);
        $payload = $domain(
            $relId,
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? '',
        );
        return $this->responder->respond($this->request, $payload);
    }
}
