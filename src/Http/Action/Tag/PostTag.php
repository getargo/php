<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\App\Content\Tag\SaveTag;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostTag
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected SaveTag $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)(
            $relId,
            [
                'title' => $this->request->input['title'],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? ''
        );
        return ($this->responder)($payload);
    }
}
