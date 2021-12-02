<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag\Add;

use Argo\Domain\App\Content\Tag\AddTag;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostTagAdd
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected AddTag $domain
    ) {
    }

    public function __invoke() : Response
    {
        $payload = ($this->domain)($this->request->input['relId'] ?? '');
        return ($this->responder)($payload);
    }
}
