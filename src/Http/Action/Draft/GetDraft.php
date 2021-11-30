<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\App\Content\Draft\FetchDraft;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetDraft extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchDraft $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)($relId);
        return ($this->responder)($payload);
    }
}
