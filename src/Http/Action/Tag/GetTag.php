<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\App\Content\Tag\FetchTag;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetTag
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchTag $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)($relId);
        return ($this->responder)($payload);
    }
}
