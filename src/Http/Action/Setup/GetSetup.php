<?php
declare(strict_types=1);

namespace Argo\Http\Action\Setup;

use Argo\Http\Action;
use Argo\App\Payload;
use Argo\App\Site\AddSite;

class GetSetup extends Action
{
    public function __invoke()
    {
        $domain = $this->container->get(AddSite::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
