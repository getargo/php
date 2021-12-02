<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\Domain\App\Dashboard;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class Get
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
