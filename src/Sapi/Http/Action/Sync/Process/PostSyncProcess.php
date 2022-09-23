<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Sync\Process;

use Argo\Domain\App\Site\SyncSite;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostSyncProcess
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected SyncSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($this, $payload);
    }
}
