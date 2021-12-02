<?php
declare(strict_types=1);

namespace Argo\Http\Action\Config;

use Argo\Domain\App\Config\FetchConfig;
use Argo\Http\Responder;
use Sapien\Request;
use Sapien\Response;

class GetConfig
{
    public function __construct(
        protected Request $request,
        protected Responder $responder,
        protected FetchConfig $domain
    ) {
    }

    public function __invoke(string $name) : Response
    {
        $payload = ($this->domain)($name);
        return ($this->responder)($payload);
    }
}
