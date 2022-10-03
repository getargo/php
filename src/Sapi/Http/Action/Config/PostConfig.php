<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Action\Config;

use Argo\App\Config\SaveConfig;
use Argo\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class PostConfig
{
    public function __construct(
        protected Request $request,
        protected ActionResponder $responder,
        protected SaveConfig $domain
    ) {
    }

    public function __invoke(string $name) : Response
    {
        $payload = ($this->domain)($name, $this->request->input['text'] ?? '');
        return ($this->responder)($this, $payload);
    }
}
