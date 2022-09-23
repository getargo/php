<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Draft\Publish;

use Argo\Domain\App\Content\Draft\PublishDraft;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostDraftPublish
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected PublishDraft $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)(
            $relId,
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
            ],
            $this->request->input['body'] ?? ''
        );
        return ($this->responder)($this, $payload);
    }
}
