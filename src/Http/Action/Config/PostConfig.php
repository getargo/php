<?php
declare(strict_types=1);

namespace Argo\Http\Action\Config;

use Argo\Http\Action;
use Argo\UseCase\Config\SaveConfig;

class PostConfig extends Action
{
    public function __invoke(string $name)
    {
        $domain = $this->container->new(SaveConfig::CLASS);
        $payload = $domain($name, $this->request->input['text'] ?? '');
        return $this->responder->respond($this->request, $payload);
    }
}
