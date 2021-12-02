<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tags;

use Argo\Domain\App\Content\Tag\FetchTags;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetTags
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchTags $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($payload);
    }
}
