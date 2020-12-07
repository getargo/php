<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sync;

use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetSync extends Action
{
    public function __invoke() : SapiResponse
    {
        return $this->response($this->request);
    }
}
