<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft\Add;

use Argo\Domain\App\Content\Draft\AddDraft;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostDraftAdd
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected AddDraft $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input['title'] ?? 'Untitled');
        return ($this->responder)($payload);
    }
}
