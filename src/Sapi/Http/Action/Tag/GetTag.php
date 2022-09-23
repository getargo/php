<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Tag;

use Argo\Domain\App\Content\Tag\FetchTag;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetTag
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchTag $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)($relId);
        return ($this->responder)($this, $payload);
    }
}
