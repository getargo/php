<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft\Publish;

use Argo\App\Content\Draft\PublishDraft;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostDraftPublish extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        PublishDraft $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string $relId) : Response
    {
        $payload = $this->domain(
            $relId,
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
            ],
            $this->request->input['body'] ?? ''
        );
        return $this->response($this->request, $payload);
    }
}
