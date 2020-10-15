<?php
declare(strict_types=1);

namespace Argo\Http\Action\Config;

use Argo\Http\Action;
use Argo\UseCase\Config\FetchConfig;

class GetConfig extends Action
{
    public function __invoke(string $name)
    {
        $domain = $this->container->new(FetchConfig::CLASS);
        $payload = $domain($name);
        return $this->responder->respond($this->request, $payload);
    }
}
