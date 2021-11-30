<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class Head
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
