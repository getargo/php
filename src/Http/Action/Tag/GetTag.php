<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\Http\Action;
use Argo\UseCase\Content\Tag\FetchTag;

class GetTag extends Action
{
    public function __invoke(string $relId)
    {
        $domain = $this->container->new(FetchTag::CLASS);
        $payload = $domain($relId);
        return $this->responder->respond($this->request, $payload);
    }
}
