<?php
declare(strict_types=1);

namespace Argo\Http\Action\Post;

use Argo\Http\Action;
use Argo\App\Content\Post\TrashPost;

class DeletePost extends Action
{
    public function __invoke(string ...$relId)
    {
        $domain = $this->container->new(TrashPost::CLASS);
        $payload = $domain($this->implode($relId));
        return $this->responder->respond($this->request, $payload);
    }
}
