<?php
declare(strict_types=1);

namespace Argo;

use Argo\Domain\Storage;
use Argo\Infra\Build;
use Argo\Infra\Log;
use Argo\Infra\Stdlog;
use Argo\Infra\System;
use Argo\Persistence\Fsio;
use Capsule\Di\Definitions;
use Capsule\Di\Provider;

class ArgoProvider implements Provider
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

        $def->{Build\Catalog::CLASS}
            ->argument('extension', '.qiq.php');
    }
}
