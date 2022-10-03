<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Sites;

use Argo\App\Site\FetchSites;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetSites
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchSites $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($this, $payload);
    }
}
