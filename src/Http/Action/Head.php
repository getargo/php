<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class Head extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder
    ) {
        parent::__construct($request, $responder);
    }

    public function __invoke() : SapiResponse
    {
        return $this->response($this->request);
    }
}
