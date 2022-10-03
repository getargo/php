<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Page;

use Argo\App\Content\Page\SavePage;
use Argo\Sapi\Http\Input;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostPage
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected SavePage $domain
    ) {
    }

    public function __invoke(string ...$idParts) : Response
    {
        $payload = ($this->domain)(
            Input::implode($idParts),
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? null,
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? '',
        );

        return ($this->responder)($this, $payload);
    }
}
