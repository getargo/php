<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\App\Content\Post\FetchPost;
use Argo\Http\Input;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetPost
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchPost $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = ($this->domain)(Input::implode($relId));
        return ($this->responder)($payload);
    }
}
