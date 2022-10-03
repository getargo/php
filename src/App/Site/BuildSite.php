<?php
declare(strict_types=1);

namespace Argo\App\Site;

use Argo\Infra\BuildFactory;
use Argo\App\Payload;
use Argo\App\App;
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
        return Payload::accepted([
            'callable' => function () {
                $this->buildFactory->new('echo')->all();
            },
        ]);
    }
}
