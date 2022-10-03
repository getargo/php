<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Page\Add;

use Argo\App\Content\Page\AddPage;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostPageAdd
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected AddPage $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input['id'] ?? '');
        return ($this->responder)($this, $payload);
    }
}
