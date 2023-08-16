<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Page;

use Argo\App\Content\Page\FetchPage;
use Argo\Sapi\Http\Input;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetPage
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchPage $domain
    ) {
    }

    public function __invoke(string ...$idParts) : Response
    {
        $payload = ($this->domain)(Input::implode($idParts));
        return ($this->responder)($this, $payload);
    }
}