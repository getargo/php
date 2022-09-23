<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Build;

use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetBuild
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder
    ) {
    }

    public function __invoke() : Response
    {
        return ($this->responder)($this);
    }
}
