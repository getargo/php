<?php
declare(strict_types=1);

namespace Argo\Http;

use Argo\Domain\Storage;
use Argo\App\Payload;
use Argo\App\Status;
use Argo\View\ViewFactory;
use Sapien\Request;
use Sapien\Response;

class Responder
{
    public function __construct(
        protected Request $request,
        protected ViewFactory $viewFactory,
        protected Storage $storage
    ) {
    }

    public function __invoke(Payload $payload = null) : Response
    {
        if ($payload === null) {
            $payload = Payload::found();
        }

        $response = new Response();
        $response->setHeader('Access-Control-Allow-Origin', '*');

        $status = $payload->getStatus();
        $result = (object) $payload->getResult();
        $forward = "/";

        switch ($status) {
            case Status::FOUND:
                $this->renderIntoResponse(
                    $response,
                    $payload,
                    $this->getViewTemplate(),
                    'layout'
                );
                break;

            case Status::NOT_FOUND:
                $response->setCode(404);
                $this->renderIntoResponse(
                    $response,
                    $payload,
                    'not-found',
                    'layout'
                );
                break;

            case Status::CREATED:
                if ($result->item->type !== 'post') {
                    // newly-created posts go back to the dashboard;
                    // everything else goes to its own editing page
                    $forward .= "{$result->item->type}/{$result->item->relId}/";
                }

                $response->setCode(201);
                $response->setHeader('X-Argo-Forward', $forward);
                break;

            case Status::UPDATED:
                $forward .= "{$result->item->type}/{$result->item->relId}/";
                $response->setHeader('X-Argo-Forward', $forward);
                break;

            case Status::DELETED:
                $forward .= in_array($result->item->type, ['draft', 'post'])
                    ? ''
                    : "{$result->item->type}s/";
                $response->setHeader('X-Argo-Forward', $forward);
                break;

            case Status::ERROR:
                $response->setCode(500);
                $this->renderIntoResponse($response, $payload, 'error');
                break;

            case Status::INVALID:
                $response->setCode(422);
                $this->renderIntoResponse($response, $payload, 'invalid');
                break;

            case Status::SUCCESS:
                $label = $this->request->method->is('GET')
                    ? 'Location'
                    : 'X-Argo-Forward';

                $response->setHeader($label, $forward);
                break;

            case Status::ACCEPTED:
                $response->setCode(202);
                break;

            case Status::PROCESSING:
                $response->setHeader('Content-Type', 'text/plain');
                $response->setCode(200);
                $response->setContent($result->callable);
                break;
        }

        return $response;
    }

    protected function getViewTemplate() : string
    {
        if ($this->request->method->is('HEAD')) {
            return '';
        }

        $path = trim($this->request->url->path, '/');
        if (trim($path) === '') {
            return 'dashboard';
        }
        $path = explode('/', $path);
        return trim(array_shift($path));
    }

    protected function renderIntoResponse(
        Response $response,
        Payload $payload,
        string $viewTemplate,
        ?string $layoutTemplate = null
    ) : void
    {
        if ($viewTemplate === '') {
            return;
        }

        $response->setHeader('Content-Type', 'text/html');
        $view = $this->viewFactory->new([
            dirname(__DIR__, 2) . '/resources/admin',
        ]);
        $view->setData($payload->getResult());
        $view->addData(['docroot' => $this->storage->path()]);
        $view->setView($viewTemplate);
        $view->setLayout($layoutTemplate);
        $content = $view();
        $response->setContent($content);
    }
}
