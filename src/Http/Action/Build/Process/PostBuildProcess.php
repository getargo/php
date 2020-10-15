<?php
declare(strict_types=1);

namespace Argo\Http\Action\Build\Process;

use Argo\Http\Action;
use Argo\UseCase\Site\BuildSite;

class PostBuildProcess extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(BuildSite::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
