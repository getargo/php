<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Post;

use Argo\App\Content\Post\FetchPost;
use Argo\Sapi\Http\Input;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class GetPost
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected FetchPost $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = ($this->domain)(Input::implode($relId));
        return ($this->responder)($this, $payload);
    }
}