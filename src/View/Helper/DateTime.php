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

    public function __invoke(string $time, string $format = 'c') : self
    {
        return $this;
    }

    public function raw(string $time, string $format = 'c') : string
    {
        return $this->dateTime->local($time, $format);
    }

    public function html(string $time, string $format = 'c') : string
    {
        return $this->escape->h($this->raw($time, $format));
    }

    public function attr(string $time, string $format = 'c') : string
    {
        return $this->escape->a($this->raw($time, $format));
    }

    public function tag(string $time, string $format = 'c', array $attr = []) : string
    {
        $attr['datetime'] = $this->raw($time, 'c');
        $attr = $this->escape->a($attr);
        return "<time $attr>" . $this->html($time, $format) . '</time>';
    }
}
