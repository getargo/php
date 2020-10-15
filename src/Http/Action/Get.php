<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\Http\Action;
use Argo\UseCase\Dashboard;

class Get extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(Dashboard::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
