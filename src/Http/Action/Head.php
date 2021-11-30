<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class Head extends Action
{
    public function __construct(
        Request $request,
        Responder $responder
    ) {
        parent::__construct($request, $responder);
    }

    public function __invoke() : Response
    {
        return ($this->responder)($this->request);
    }
}
