<?php
declare(strict_types=1);

namespace Argo\Http\Action\Import;

use Argo\App\Payload;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetImport extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder
    ) {
    }

    public function __invoke() : Response
    {
        return ($this->responder)();
    }
}
