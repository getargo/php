<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\App\Content\Post\SavePost;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostPost extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        SavePost $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string ...$relId) : Response
    {

        $payload = $this->domain(
            $this->implode($relId),
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? ''
        );

        return $this->response($this->request, $payload);
    }
}
