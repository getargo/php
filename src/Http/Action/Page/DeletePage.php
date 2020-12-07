<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\Http\Action;
use Argo\App\Content\Page\TrashPage;

class DeletePage extends Action
{
    public function __invoke(string ...$idParts)
    {
        $domain = $this->container->new(TrashPage::CLASS);
        $payload = $domain($this->implode($idParts));
        return $this->responder->respond($this->request, $payload);
    }
}
