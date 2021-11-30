<?php
declare(strict_types=1);

namespace Argo\Http\Action\Build\Process;

use Argo\App\Site\BuildSite;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostBuildProcess
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected BuildSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
