<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\Domain\App\Content\Draft\TrashDraft;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class DeleteDraft
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected TrashDraft $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)($relId);
        return ($this->responder)($payload);
    }
}
