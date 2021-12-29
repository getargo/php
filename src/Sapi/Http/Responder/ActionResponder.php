<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Responder;

use Otto\Sapi\Http\Responder\ActionResponder as OttoActionResponder;
use Sapien\Response;

class ActionResponder extends OttoActionResponder
{
    protected function respondAccepted() : Response
    {
        $this->layout = null;
        return parent::respondAccepted();
    }

    protected function respondCreated() : Response
    {
        $this->layout = null;
        $item = $this->payload->getResult()['item'];

        // newly-created posts go back to the dashboard;
        // everything else goes to its own editing page
        $forward = ($item->type === 'post')
            ? '/'
            : "/{$item->type}/{$item->relId}/";

        return parent::respondCreated()
            ->setHeader('X-Argo-Forward', $forward);
    }

    protected function respondDeleted() : Response
    {
        $this->layout = null;
        $item = $this->payload->getResult()['item'];
        $forward = in_array($item->type, ['draft', 'post'])
            ? '/'
            : "/{$item->type}s/";

        return parent::respondDeleted()
            ->setHeader('X-Argo-Forward', $forward);
    }

    protected function respondError() : Response
    {
        $this->layout = null;
        return parent::respondError();
    }

    protected function respondInvalid() : Response
    {
        $this->layout = null;
        return parent::respondInvalid();
    }

    protected function respondProcessing() : Response
    {
        $this->layout = null;
        $callable = $this->payload->getResult()['callable'];

        return parent::respondSuccess()
            ->setCode(200)
            ->setHeader('Content-Type', 'text/plain')
            ->setContent($result->callable);
    }

    protected function respondSuccess() : Response
    {
        $this->layout = null;
        $label = $this->request->method->is('GET')
            ? 'Location'
            : 'X-Argo-Forward';

        return parent::respondSuccess()
            ->setHeader($label, '/');
    }

    protected function respondUpdated() : Response
    {
        $this->layout = null;
        $item = $this->payload->getResult()['item'];
        $forward = "/{$item->type}/{$item->relId}/";

        return parent::respondUpdated()
            ->setHeader('X-Argo-Forward', $forward);
    }
}
