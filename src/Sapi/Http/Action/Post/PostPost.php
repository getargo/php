<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Post;

use Argo\Domain\App\Content\Post\SavePost;
use Argo\Sapi\Http\Input;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostPost implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected SavePost $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {

        $payload = ($this->domain)(
            Input::implode($relId),
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? ''
        );

        return ($this->responder)($this, $payload);
    }
}
