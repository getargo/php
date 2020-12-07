<?php
declare(strict_types=1);

namespace Argo\Http\Action\Site;

use Argo\Http\Action;
use Argo\App\Payload;
use Argo\App\Site\SwapSite;

class GetSite extends Action
{
    public function __invoke(string $name)
    {
        $domain = $this->container->get(SwapSite::CLASS);
        $payload = $domain($name);
        return $this->responder->respond($this->request, $payload);
    }
}
