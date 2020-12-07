<?php
declare(strict_types=1);

namespace Argo\Http\Action\Folder;

use Argo\Http\Action;
use Argo\App\OpenFolder;

class GetFolder extends Action
{
    public function __invoke(string ...$idParts)
    {
        $domain = $this->container->new(OpenFolder::CLASS);
        $payload = $domain($this->implode($idParts));
        return $this->responder->respond($this->request, $payload);
    }
}
