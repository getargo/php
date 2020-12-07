<?php
declare(strict_types=1);

namespace Argo\Http\Action\Setup;

use Argo\App\Site\AddSite;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetSetup extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        AddSite $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : SapiResponse
    {
        $payload = $this->domain();
        return $this->response($this->request, $payload);
    }
}
