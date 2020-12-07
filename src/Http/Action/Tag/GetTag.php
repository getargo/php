<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\App\Content\Tag\FetchTag;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetTag extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        FetchTag $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string $relId) : SapiResponse
    {
        $payload = $this->domain($relId);
        return $this->response($this->request, $payload);
    }
}
