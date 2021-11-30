<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sync\Process;

use Argo\App\Site\SyncSite;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostSyncProcess
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected SyncSite $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
