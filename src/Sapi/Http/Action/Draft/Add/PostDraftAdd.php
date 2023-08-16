<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Draft\Add;

use Argo\App\Content\Draft\AddDraft;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostDraftAdd
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected AddDraft $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input['title'] ?? 'Untitled');
        return ($this->responder)($this, $payload);
    }
}