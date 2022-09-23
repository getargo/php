<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Tag;

use Argo\Domain\App\Content\Tag\SaveTag;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostTag
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
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
        return ($this->responder)($this, $payload);
    }
}
