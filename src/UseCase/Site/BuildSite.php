<?php
declare(strict_types=1);

namespace Argo\UseCase\Site;

use Argo\Infrastructure\BuildFactory;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;
use Throwable;

class BuildSite extends UseCase
{
    protected $buildFactory;

    public function __construct(BuildFactory $buildFactory)
    {
        $this->buildFactory = $buildFactory;
    }

    protected function exec() : Payload
    {
        return Payload::processing([
            'callable' => function () {
                $this->buildFactory->new('echo')->all();
            },
        ]);
    }
}
