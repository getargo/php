<?php
declare(strict_types=1);

namespace Argo\Http;

use Argo\App\Payload;
use Argo\App\UseCase;
use SapiRequest;
use SapiResponse;

abstract class Action
{
    protected $request;

    protected $responder;

    protected $domain;

    public function __construct(
        SapiRequest $request,
        Responder $responder,
        ?UseCase $domain = null
    ) {
        $this->request = $request;
        $this->responder = $responder;
        $this->domain = $domain;
    }

    protected function domain(...$args) : Payload
    {
        return $this->domain->__invoke(...$args);
    }

    protected function response(
        SapiRequest $request,
        Payload $payload = null
    ) : SapiResponse
    {
        if ($payload === null) {
            $payload = Payload::found();
        }

        return $this->responder->respond($request, $payload);
    }

    protected function implode(array $parts) : string
    {
        return trim(implode('/', $parts), '/');
    }
}
