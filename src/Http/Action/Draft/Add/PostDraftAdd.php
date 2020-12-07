<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft\Add;

use Argo\Http\Action;
use Argo\App\Content\Draft\AddDraft;

class PostDraftAdd extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(AddDraft::CLASS);
        $payload = $domain($this->request->input['title'] ?? 'Untitled');
        return $this->responder->respond($this->request, $payload);
    }
}
