<?php
declare(strict_types=1);

namespace Argo\Http\Action\Site;

use Argo\App\Site\SwapSite;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetSite extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        SwapSite $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string $name) : SapiResponse
    {
        $payload = $this->domain($name);
        return $this->response($this->request, $payload);
    }
}
