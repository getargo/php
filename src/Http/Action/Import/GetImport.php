<?php
declare(strict_types=1);

namespace Argo\Http\Action\Import;

use Argo\App\Payload;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetImport extends Action
{
    public function __invoke() : SapiResponse
    {
        return $this->response($this->request);
    }
}
