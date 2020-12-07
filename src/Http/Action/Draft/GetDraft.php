<?php
declare(strict_types=1);

namespace Argo\Http\Action\Draft;

use Argo\Http\Action;
use Argo\App\Content\Draft\FetchDraft;

class GetDraft extends Action
{
    public function __invoke(string $relId)
    {
        $domain = $this->container->new(FetchDraft::CLASS);
        $payload = $domain($relId);
        return $this->responder->respond($this->request, $payload);
    }
}
