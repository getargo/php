<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\App\Content\Draft\TrashDraft;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class DeleteDraft extends Action
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
