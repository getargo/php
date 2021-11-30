<?php
declare(strict_types=1);

namespace Argo\Http\Action\Setup;

use Argo\App\Site\AddSite;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetSetup
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected AddSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
