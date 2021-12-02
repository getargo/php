<?php
declare(strict_types=1);

namespace Argo\Http\Action\Site;

use Argo\Domain\App\Site\SwapSite;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetSite
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected SwapSite $domain
    ) {
    }

    public function __invoke(string $name) : Response
    {
        $payload = ($this->domain)($name);
        return ($this->responder)($payload);
    }
}
