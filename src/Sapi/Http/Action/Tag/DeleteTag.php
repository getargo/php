<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Tag;

use Argo\Domain\App\Content\Tag\TrashTag;
use Argo\Sapi\Http\Input;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class DeleteTag implements \Otto\Sapi\Http\Action
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
