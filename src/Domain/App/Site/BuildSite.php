<?php
declare(strict_types=1);

namespace Argo\Domain\App\Site;

use Argo\Infra\BuildFactory;
use Argo\Domain\Payload;
use Argo\Domain\App;
use Throwable;

class BuildSite extends App
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
