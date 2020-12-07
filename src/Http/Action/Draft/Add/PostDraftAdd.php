<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft\Add;

use Argo\App\Content\Draft\AddDraft;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class PostDraftAdd extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        AddDraft $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : SapiResponse
    {
        $payload = $this->domain($this->request->input['title'] ?? 'Untitled');
        return $this->response($this->request, $payload);
    }
}
