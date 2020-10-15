<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag\Add;

use Argo\Http\Action;
use Argo\UseCase\Content\Tag\AddTag;

class PostTagAdd extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(AddTag::CLASS);
        $payload = $domain($this->request->input['relId'] ?? '');
        return $this->responder->respond($this->request, $payload);
    }
}
