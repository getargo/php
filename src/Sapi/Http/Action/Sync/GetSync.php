<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Sync;

use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetSync implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder
    ) {
    }

    public function __invoke() : Response
    {
        return ($this->responder)($this);
    }
}
