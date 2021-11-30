<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\App\Dashboard;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class Get extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected Dashboard $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
