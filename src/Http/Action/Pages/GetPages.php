<?php
declare(strict_types=1);

namespace Argo\Http\Action\Pages;

use Argo\Domain\App\Content\Page\FetchPages;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetPages
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchPages $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
