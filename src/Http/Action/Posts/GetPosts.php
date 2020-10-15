<?php
declare(strict_types=1);

namespace Argo\Http\Action\Posts;

use Argo\Http\Action;
use Argo\UseCase\Content\Post\FetchPosts;

class GetPosts extends Action
{
    public function __invoke(int $page = 1)
    {
        $domain = $this->container->new(FetchPosts::CLASS);
        $payload = $domain($page);
        return $this->responder->respond($this->request, $payload);
    }
}
