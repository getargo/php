<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\App\Content\Tag\SaveTag;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class PostTag extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        SaveTag $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string $relId) : SapiResponse
    {
        $payload = $this->domain(
            $relId,
            [
                'title' => $this->request->input['title'],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? ''
        );
        return $this->response($this->request, $payload);
    }
}
