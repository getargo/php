<?php
declare(strict_types=1);

namespace Argo\Http\Action\Site;

use Argo\Http\Action;
use Argo\UseCase\Payload;
use Argo\UseCase\Site\AddSite;

class PostSite extends Action
{
    public function __invoke()
    {
        $domain = $this->container->get(AddSite::CLASS);
        $payload = $domain($this->request->input);
        return $this->responder->respond($this->request, $payload);
    }
}
