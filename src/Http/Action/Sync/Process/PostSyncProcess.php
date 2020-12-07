<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sync\Process;

use Argo\App\Site\SyncSite;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class PostSyncProcess extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        SyncSite $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : SapiResponse
    {
        $payload = $this->domain();
        return $this->response($this->request, $payload);
    }
}
