<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;
use Argo\Domain\Storage;
use Capsule\Di\Definitions;
use Capsule\Di\Provider;
use Capsule\Di\Lazy;

class InfraProvider implements Provider
{
    public function provide(Definitions $def) : void
    {
        $def->object(Log::CLASS, Stdlog::CLASS);

        $def->object(Storage::CLASS, Fsio::CLASS)
            ->argument(
                'docroot',
                Lazy::getCall(System::CLASS, 'docroot')
            );
    }
}
