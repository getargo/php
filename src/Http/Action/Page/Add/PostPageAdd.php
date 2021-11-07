<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page\Add;

use Argo\App\Content\Page\AddPage;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostPageAdd extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        AddPage $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : Response
    {
        $payload = $this->domain($this->request->input['id'] ?? '');
        return $this->response($this->request, $payload);
    }
}
