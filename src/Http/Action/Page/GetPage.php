<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\App\Content\Page\FetchPage;
use Argo\Http\Input;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetPage
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchPage $domain
    ) {
    }

    public function __invoke(string ...$idParts) : Response
    {
        $payload = ($this->domain)(Input::implode($idParts));
        return ($this->responder)($payload);
    }
}
