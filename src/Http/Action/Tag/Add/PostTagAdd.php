<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag\Add;

use Argo\App\Content\Tag\AddTag;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostTagAdd extends Action
{
    public function __construct(
        Request $request,
        Responder $responder,
        AddTag $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke() : Response
    {
        $payload = $this->domain($this->request->input['relId'] ?? '');
        return $this->response($this->request, $payload);
    }
}
