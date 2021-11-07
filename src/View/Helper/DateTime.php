<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\Domain\DateTime as DateTimeFormat;
use Qiq\Escape;
use Qiq\Helper\Helper;

class DateTime extends Helper
{
    public function __construct(
        Escape $escape,
        DateTimeFormat $dateTime
    ) {
        parent::__construct($escape);
        $this->dateTime = $dateTime;
    }

    public function __invoke(string $time, string $format = 'c') : string
    {
        return $this->escape->h(
            $this->dateTime->local($time, $format)
        );
    }
}
