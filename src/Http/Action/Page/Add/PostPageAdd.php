<?php
declare(strict_types=1);

namespace Argo\Http\Action\Page\Add;

use Argo\Http\Action;
use Argo\App\Content\Page\AddPage;

class PostPageAdd extends Action
{
    public function __invoke()
    {
        $domain = $this->container->new(AddPage::CLASS);
        $payload = $domain($this->request->input['id'] ?? '');
        return $this->responder->respond($this->request, $payload);
    }
}
