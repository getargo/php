<?php
declare(strict_types=1);

namespace Argo\Http\Action\Pages;

use Argo\App\Content\Page\FetchPages;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetPages extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        FetchPages $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : Response
    {
        $payload = $this->domain();
        return $this->response($this->request, $payload);
    }
}
