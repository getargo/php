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
        Request $request,
        Responder $responder,
        TrashTag $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string ...$relId) : Response
    {
        $payload = $this->domain($this->implode($relId));
        return $this->response($this->request, $payload);
    }
}
