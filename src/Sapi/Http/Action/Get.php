<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action;

use Argo\App\Dashboard\FetchDashboard;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class Get
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchDashboard $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($this, $payload);
    }
}
