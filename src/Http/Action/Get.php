<?php
declare(strict_types=1);

namespace Argo\Http\Action;

use Argo\App\Dashboard;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class Get extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        Dashboard $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : Response
    {
        $payload = $this->domain();
        return $this->response($this->request, $payload);
    }
}
