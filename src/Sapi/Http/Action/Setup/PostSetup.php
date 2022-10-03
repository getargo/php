<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Setup;

use Argo\App\Site\AddSite;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostSetup
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected AddSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input);
        return ($this->responder)($this, $payload);
    }
}
