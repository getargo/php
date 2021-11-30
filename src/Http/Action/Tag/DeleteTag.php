<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\App\Content\Tag\TrashTag;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class DeleteTag extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected TrashTag $domain
    ) {
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = ($this->domain)($this->implode($relId));
        return ($this->responder)($payload);
    }
}
