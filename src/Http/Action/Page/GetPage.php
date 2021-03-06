<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page;

use Argo\App\Content\Page\FetchPage;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetPage extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        FetchPage $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string ...$idParts) : SapiResponse
    {
        $payload = $this->domain($this->implode($idParts));
        return $this->response($this->request, $payload);
    }
}
