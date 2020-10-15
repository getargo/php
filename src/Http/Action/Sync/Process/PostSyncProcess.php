<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sync\Process;

use Argo\Http\Action;
use Argo\UseCase\Site\SyncSite;

class PostSyncProcess extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(SyncSite::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
