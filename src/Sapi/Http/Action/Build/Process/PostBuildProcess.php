<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Build\Process;

use Argo\App\Site\BuildSite;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostBuildProcess
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected BuildSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($this, $payload);
    }
}
