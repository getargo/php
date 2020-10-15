<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\Http\Action;
use Argo\UseCase\Dashboard;

class Head extends Action
{
    public function __invoke()
    {
        return $this->responder->respond($this->request);
    }
}
