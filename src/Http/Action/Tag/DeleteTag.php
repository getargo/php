<?php
declare(strict_types=1);

namespace Argo\Http\Action\Tag;

use Argo\Http\Action;
use Argo\App\Content\Tag\TrashTag;

class DeleteTag extends Action
{
    public function __invoke(string ...$relId)
    {
        $domain = $this->container->new(TrashTag::CLASS);
        $payload = $domain($this->implode($relId));
        return $this->responder->respond($this->request, $payload);
    }
}
