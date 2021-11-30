<?php
declare(strict_types=1);

namespace Argo\Http\Action\Config;

use Argo\App\Config\SaveConfig;
use Argo\Http\Action;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class PostConfig extends Action
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected SaveConfig $domain
    ) {
    }

    public function __invoke(string $name) : Response
    {
        $payload = ($this->domain)($name, $this->request->input['text'] ?? '');
        return ($this->responder)($payload);
    }
}
