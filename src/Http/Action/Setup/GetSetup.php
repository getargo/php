<?php
declare(strict_types=1);

namespace Argo\Http\Action\Setup;

use Argo\Http\Action;
use Argo\UseCase\Payload;
use Argo\UseCase\Site\AddSite;

class GetSetup extends Action
{
    public function __invoke()
    {
        $domain = $this->container->get(AddSite::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
