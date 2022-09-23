<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Tags;

use Argo\Domain\App\Content\Tag\FetchTags;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetTags
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchTags $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)();
        return ($this->responder)($this, $payload);
    }
}
