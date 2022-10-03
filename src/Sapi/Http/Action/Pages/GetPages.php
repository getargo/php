<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Pages;

use Argo\App\Content\Page\FetchPages;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetPages
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchPages $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($this, $payload);
    }
}
