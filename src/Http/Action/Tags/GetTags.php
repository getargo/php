<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tags;

use Argo\Http\Action;
use Argo\UseCase\Content\Tag\FetchTags;

class GetTags extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(FetchTags::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
