<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Responder;

use Argo\Domain\Storage;
use Otto\Sapi\Http\Responder\Data as OttoResponderData;

class Data extends OttoResponderData
{
    public function __construct(protected Storage $storage)
    {
    }

    public function get() : array
    {
        return [
            'docroot' => $this->storage->path(),
        ];
    }
}
