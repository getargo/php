<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Config;

use Argo\Domain\App\Config\FetchConfig;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetConfig implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchConfig $domain
    ) {
    }

    public function __invoke(string $name) : Response
    {
        $payload = ($this->domain)($name);
        return ($this->responder)($this, $payload);
    }
}
