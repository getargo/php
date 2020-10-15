<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\Http\Action;
use Argo\UseCase\Content\Tag\SaveTag;

class PostTag extends Action
{
    public function __invoke(string $relId)
    {
        $domain = $this->container->new(SaveTag::CLASS);
        $payload = $domain(
            $relId,
            [
                'title' => $this->request->input['title'],
            ],
            $this->request->input['body'] ?? ''
        );
        return $this->responder->respond($this->request, $payload);
    }
}
