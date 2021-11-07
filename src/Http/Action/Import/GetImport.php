<?php
declare(strict_types=1);

namespace Argo\Http\Action\Import;

use Argo\App\Payload;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetImport extends Action
{
    public function __construct(
        Request $request,
        Responder $responder
    ) {
        parent::__construct($request, $responder);
    }

    public function __invoke() : Response
    {
        return $this->response($this->request);
    }
}
