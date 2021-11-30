<?php
declare(strict_types=1);

namespace Argo\Http\Action\Folder;

use Argo\App\OpenFolder;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetFolder extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected OpenFolder $domain
    ) {
    }

    public function __invoke(string ...$idParts) : Response
    {
        $payload = ($this->domain)($this->implode($idParts));
        return ($this->responder)($payload);
    }
}
