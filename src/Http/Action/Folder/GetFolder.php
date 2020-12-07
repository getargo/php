<?php
declare(strict_types=1);

namespace Argo\Http\Action\Folder;

use Argo\App\OpenFolder;
use Argo\Http\Action;
use Argo\Http\Responder;
use SapiRequest;
use SapiResponse;

class GetFolder extends Action
{
    public function __construct(
        SapiRequest $request,
        Responder $responder,
        OpenFolder $domain
    ) {
        parent::__construct($request, $responder, $domain);
    }

    public function __invoke(string ...$idParts) : SapiResponse
    {
        $payload = $this->domain($this->implode($idParts));
        return $this->response($this->request, $payload);
    }
}
