<?php
declare(strict_types=1);

namespace Argo\Http\Action\Import;

use Argo\Domain\App\Import\Import;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostImport
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected Import $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->uploads['wpxml'] ?? null);
        return ($this->responder)($payload);
    }
}
