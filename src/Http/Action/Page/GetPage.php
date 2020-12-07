<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\Http\Action;
use Argo\App\Content\Page\FetchPage;

class GetPage extends Action
{
    public function __invoke(string ...$idParts)
    {
        $domain = $this->container->new(FetchPage::CLASS);
        $payload = $domain($this->implode($idParts));
        return $this->responder->respond($this->request, $payload);
    }
}
