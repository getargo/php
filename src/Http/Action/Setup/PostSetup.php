<?php
declare(strict_types=1);

namespace Argo\Http\Action\Setup;

use Argo\App\Site\AddSite;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostSetup extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        AddSite $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : Response
    {
        $payload = $this->domain($this->request->input);
        return $this->response($this->request, $payload);
    }
}
