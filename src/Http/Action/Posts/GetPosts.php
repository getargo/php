<?php
declare(strict_types=1);

namespace Argo\Http\Action\Posts;

use Argo\App\Content\Post\FetchPosts;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetPosts
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchPosts $domain
    ) {
    }

    public function __invoke(int $page = 1) : Response
    {
        $payload = ($this->domain)($page);
        return ($this->responder)($payload);
    }
}
