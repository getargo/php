<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Tag;

use Argo\App\Content\Tag\TrashTag;
use Argo\Sapi\Http\Input;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class DeleteTag
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected TrashTag $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = ($this->domain)(Input::implode($relId));
        return ($this->responder)($this, $payload);
    }
}
