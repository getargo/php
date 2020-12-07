<?php
declare(strict_types=1);

namespace Argo\Http\Action\Sync;

use Argo\Http\Action;
use Argo\App\Payload;

class GetSync extends Action
{
    public function __invoke()
    {
        return $this->responder->respond($this->request);
    }
}
