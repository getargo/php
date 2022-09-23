<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\Infra\Template\Helper;
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
    }
}
