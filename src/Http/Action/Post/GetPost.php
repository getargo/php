<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\App\Content\Post\FetchPost;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetPost extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchPost $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = ($this->domain)($this->implode($relId));
        return ($this->responder)($payload);
    }
}
