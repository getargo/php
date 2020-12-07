<?php
declare(strict_types=1);

namespace Argo\Http\Action\Posts;

use Argo\App\Content\Post\FetchPosts;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetPosts extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        FetchPosts $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(int $page = 1) : SapiResponse
    {
        $payload = $this->domain($page);
        return $this->response($this->request, $payload);
    }
}
