<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Draft;

use Argo\Domain\App\Content\Draft\TrashDraft;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class DeleteDraft implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected TrashDraft $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)($relId);
        return ($this->responder)($this, $payload);
    }
}
