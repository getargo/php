<?php
declare(strict_types=1);

namespace Argo\Infra\Build\Helper;

use Argo\Domain\Model\DateTime as DateTimeFormat;
use Qiq\Helper\Html\Escape;

class DateTime
{
    public function __construct(
        Escape $escape,
        DateTimeFormat $dateTime
    ) {
        $this->escape = $escape;
        $this->dateTime = $dateTime;
    }

    public function __invoke(string $time, string $format = 'c') : string
    {
        return $this->escape->h(
            $this->dateTime->local($time, $format)
        );
    }
}
