<?php
declare(strict_types=1);

namespace Argo\Http;

use Capsule\Di\Container;
use SapiRequest;

abstract class Action
{
    protected $container;

    protected $request;

    protected $responder;

    public function __construct(
        Container $container,
        SapiRequest $request,
        Responder $responder
    ) {
        $this->container = $container;
        $this->request = $request;
        $this->responder = $responder;
    }

    protected function implode(array $parts) : string
    {
        return trim(implode('/', $parts), '/');
    }
}
