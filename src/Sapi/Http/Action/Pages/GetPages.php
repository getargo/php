<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Pages;

use Argo\Domain\App\Content\Page\FetchPages;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetPages implements \Otto\Sapi\Http\Action
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
