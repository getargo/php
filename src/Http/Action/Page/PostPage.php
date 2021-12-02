<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\Domain\App\Content\Page\SavePage;
use Argo\Http\Input;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostPage
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
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

        return ($this->responder)($payload);
    }
}
