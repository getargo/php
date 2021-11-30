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
        protected Request $request,
        protected Responder $responder,
        protected AddPage $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input['id'] ?? '');
        return ($this->responder)($payload);
    }
}
