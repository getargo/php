<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Template\Helper;

use AutoRoute\Generator;

class Route
{
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function __invoke(string $class, ...$params) : string
    {
        return $this->generator->generate($class, ...$params);
    }
}
