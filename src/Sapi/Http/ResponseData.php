<?php
declare(strict_types=1);

namespace Argo\Sapi\Http;

use Argo\Domain\Storage;
use Otto\Sapi\Http\ResponseData as OttoResponseData;
use Otto\Sapi\Http\ResponseTemplate;

class ResponseData extends OttoResponseData
{
    public function __construct(protected Storage $storage)
    {
    }

    public function __invoke(ResponseTemplate $responseTemplate) : void
    {
        $responseTemplate->addData([
            'docroot' => $this->storage->path() ?? "DOCROOT",
        ]);
    }
}
