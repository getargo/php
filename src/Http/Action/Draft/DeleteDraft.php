<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\Http\Action;
use Argo\UseCase\Content\Draft\TrashDraft;

class DeleteDraft extends Action
{
    public function __invoke(string $relId)
    {
        $domain = $this->container->new(TrashDraft::CLASS);
        $payload = $domain($relId);
        return $this->responder->respond($this->request, $payload);
    }
}
