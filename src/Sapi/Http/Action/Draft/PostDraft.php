<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Draft;

use Argo\Domain\App\Content\Draft\SaveDraft;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

/**
 * this should probably be `PATCH /draft/$relId`
 */
class PostDraft implements \Otto\Sapi\Http\Action
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected SaveDraft $domain
    ) {
    }

    public function __invoke(string $relId) : Response
    {
        $payload = ($this->domain)(
            $relId,
            [
                'title' => $this->request->input['title'] ?? null,
                'author' => $this->request->input['author'] ?? null,
                'tags' => $this->request->input['tags'] ?? [],
                'markup' => $this->request->input['markup'] ?? 'markdown',
            ],
            $this->request->input['body'] ?? '',
        );
        return ($this->responder)($this, $payload);
    }
}
