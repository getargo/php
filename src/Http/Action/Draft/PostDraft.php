<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\App\Content\Draft\SaveDraft;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

/**
 * this should probably be `PATCH /draft/$relId`
 */
class PostDraft extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        SaveDraft $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string $relId) : SapiResponse
    {
        $payload = $this->domain(
            $relId,
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? '',
        );
        return $this->response($this->request, $payload);
    }
}
