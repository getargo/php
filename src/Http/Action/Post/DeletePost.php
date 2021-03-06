<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\App\Content\Post\TrashPost;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class DeletePost extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        TrashPost $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string ...$relId) : SapiResponse
    {
        $payload = $this->domain($this->implode($relId));
        return $this->response($this->request, $payload);
    }
}
