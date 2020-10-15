<?php
declare(strict_types=1);

namespace Argo\Http\Action\Pages;

use Argo\Http\Action;
use Argo\UseCase\Content\Page\FetchPages;

class GetPages extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(FetchPages::CLASS);
        $payload = $domain();
        return $this->responder->respond($this->request, $payload);
    }
}
