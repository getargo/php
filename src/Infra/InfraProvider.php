<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\View\Helper;
use Capsule\Di\Definitions;
use Capsule\Di\Lazy;
use Capsule\Di\Provider;

class InfraProvider implements Provider
{
    public function provide(Definitions $def) : void
    {
        $def->{Log::CLASS}
            ->class(Stdlog::CLASS);

        $def->{Storage::CLASS}
            ->class(Fsio::CLASS);

        $def->{Fsio::CLASS}
            ->argument(
                'docroot',
                $def->getCall(System::CLASS, 'docroot')
            );

        $def->{QiqProvider::HELPER_FACTORIES}->merge([
            'anchorLocal' => $def->callableGet(Helper\AnchorLocal::CLASS),
            'anchorOpenFolder' => $def->callableGet(Helper\AnchorOpenFolder::CLASS),
            'body' => $def->callableGet(Helper\Body::CLASS),
            'bodyLess' => $def->callableGet(Helper\BodyLess::CLASS),
            'bodyPreview' => $def->callableGet(Helper\BodyPreview::CLASS),
            'dateTime' => $def->callableGet(Helper\DateTime::CLASS),
            'penders' => $def->callableGet(Helper\Penders::CLASS),
            'route' => $def->callableGet(Helper\Route::CLASS),
            'routeSubmit' => $def->callableGet(Helper\RouteSubmit::CLASS),
        ]);
    }
}
