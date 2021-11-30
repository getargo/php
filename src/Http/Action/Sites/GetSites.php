<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sites;

use Argo\App\Site\FetchSites;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetSites
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchSites $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
