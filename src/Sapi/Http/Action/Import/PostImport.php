<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Import;

use Argo\App\Import\Import;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostImport
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected Import $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->uploads['wpxml'] ?? null);
        return ($this->responder)($this, $payload);
    }
}
