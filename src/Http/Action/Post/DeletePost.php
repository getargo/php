<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\Domain\App\Content\Post\TrashPost;
use Argo\Http\Input;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class DeletePost
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected TrashPost $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = ($this->domain)(Input::implode($relId));
        return ($this->responder)($payload);
    }
}
