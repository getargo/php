<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Responder\Template;

use Argo\Domain\Storage;
use Otto\Sapi\Http\Responder\Template\TemplateData as OttoTemplateData;

class TemplateData extends OttoTemplateData
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
