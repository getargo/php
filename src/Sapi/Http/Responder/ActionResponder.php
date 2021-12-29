<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Responder;

use Otto\Sapi\Http\Responder\ActionResponder as OttoActionResponder;
use Sapien\Response;
use Argo\Domain\Status;

class ActionResponder extends OttoActionResponder
{
    protected function respondAccepted() : Response
    {
        return $this->newResponse(
            code: 202,
            view: false,
            layout: false
        );
    }

    protected function respondCreated() : Response
    {
        // newly-created posts go back to the dashboard;
        // everything else goes to its own editing page
        $item = $this->payload->getResult()['item'];
        $forward = ($item->type === 'post')
            ? '/'
            : "/{$item->type}/{$item->relId}/";

        return $this
            ->newResponse(
                code: 201,
                view: false,
                layout: false
            )
            ->setHeader('X-Argo-Forward', $forward);
    }

    protected function respondDeleted() : Response
    {
        $item = $this->payload->getResult()['item'];
        $forward = in_array($item->type, ['draft', 'post'])
            ? '/'
            : "/{$item->type}s/";

        return $this
            ->newResponse(
                code: 200,
                view: false,
                layout: false
            )
            ->setHeader('X-Argo-Forward', $forward);
    }

    protected function respondError() : Response
    {
        return $this->newResponse(
            code: 500,
            view: 'status:Error',
            layout: false
        );
    }

    protected function respondInvalid() : Response
    {
        return $this->newResponse(
            code: 422,
            view: 'status:Invalid',
            layout: false,
        );
    }

    protected function respondNotFound() : Response
    {
        return $this->newResponse(
            code: 404,
            view: 'status:NotFound',
        );
    }

    protected function respondProcessing() : Response
    {
        $callable = $this->payload->getResult()['callable'];

        return $this
            ->newResponse(
                code: 200,
                view: false,
                layout: false
            )
            ->setHeader('Content-Type', 'text/plain')
            ->setContent($callable);
    }

    protected function respondSuccess() : Response
    {
        $label = $this->request->method->is('GET')
            ? 'Location'
            : 'X-Argo-Forward';

        return $this
            ->newResponse(
                code: 200,
                view: false,
                layout: false
            )
            ->setHeader($label, '/');
    }

    protected function respondUpdated() : Response
    {
        $item = $this->payload->getResult()['item'];
        $forward = "/{$item->type}/{$item->relId}/";

        return $this
            ->newResponse(
                code: 200,
                view: false,
                layout: false
            )
            ->setHeader('X-Argo-Forward', $forward);
    }
}
