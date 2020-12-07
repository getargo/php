<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sites;

use Argo\Http\Action;
use Argo\App\Payload;
use Argo\App\Site\FetchSites;

class GetSites extends Action
{
    public function __invoke()
    {
        $domain = $this->container->get(FetchSites::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
