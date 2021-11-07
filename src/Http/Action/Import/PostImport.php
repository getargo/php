<?php
declare(strict_types=1);

namespace Argo\Http\Action\Import;

use Argo\App\Import\Import;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostImport extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        Import $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : Response
    {
        $payload = $this->domain($this->request->uploads['wpxml'] ?? null);
        return $this->response($this->request, $payload);
    }
}
