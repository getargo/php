<?php
declare(strict_types=1);

namespace Argo\Http\Action\Build\Process;

use Argo\App\Site\BuildSite;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class PostBuildProcess extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        BuildSite $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : SapiResponse
    {
        $payload = $this->domain();
        return $this->response($this->request, $payload);
    }
}
