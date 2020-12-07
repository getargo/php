<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\App\Content\Page\SavePage;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class PostPage extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        SavePage $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string ...$idParts) : SapiResponse
    {
        $payload = $this->domain(
            $this->implode($idParts),
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? null,
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? '',
        );

        return $this->response($this->request, $payload);
    }
}
