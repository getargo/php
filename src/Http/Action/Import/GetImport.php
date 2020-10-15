<?php
declare(strict_types=1);

namespace Argo\Http\Action\Import;

use Argo\Http\Action;
use Argo\UseCase\Payload;

class GetImport extends Action
{
    public function __invoke()
    {
        return $this->responder->respond($this->request);
    }
}
