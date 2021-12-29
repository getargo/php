<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Posts;

use Argo\Domain\App\Content\Post\FetchPosts;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetPosts implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchPosts $domain
    ) {
    }

    public function __invoke(int $page = 1) : Response
    {
        $payload = ($this->domain)($page);
        return ($this->responder)($this, $payload);
    }
}
