<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\App\Content\Draft\TrashDraft;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class DeleteDraft extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        TrashDraft $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string $relId) : SapiResponse
    {
        $payload = $this->domain($relId);
        return $this->response($this->request, $payload);
    }
}
