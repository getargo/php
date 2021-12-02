<?php
declare(strict_types=1);

namespace Argo\Http\Action\Site;

use Argo\Domain\App\Site\AddSite;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostSite
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected AddSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input);
        return ($this->responder)($payload);
    }
}
