<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\Http\Action;
use Argo\App\Content\Page\SavePage;

class PostPage extends Action
{
    public function __invoke(string ...$idParts)
    {
        $domain = $this->container->new(SavePage::CLASS);
        $payload = $domain(
            $this->implode($idParts),
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? null,
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? '',
        );

        return $this->responder->respond($this->request, $payload);
    }
}
