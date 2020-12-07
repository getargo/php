<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sites;

use Argo\App\Site\FetchSites;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetSites extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        FetchSites $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : SapiResponse
    {
        $payload = $this->domain();
        return $this->response($this->request, $payload);
    }
}
