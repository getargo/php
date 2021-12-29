<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Tag\Add;

use Argo\Domain\App\Content\Tag\AddTag;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostTagAdd implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected AddTag $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input['relId'] ?? '');
        return ($this->responder)($this, $payload);
    }
}
