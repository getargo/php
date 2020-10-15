<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\Domain\DateTime as DateTimeFormat;
use Aura\Html\Escaper;
use Aura\Html\Helper\AbstractHelper;

class DateTime extends AbstractHelper
{
    public function __construct(
        Escaper $escaper,
        DateTimeFormat $dateTime
    ) {
        parent::__construct($escaper);
        $this->dateTime = $dateTime;
    }

    public function __invoke() : self
    {
        return $this;
    }

    public function raw(string $time, string $format = 'c') : string
    {
        return $this->dateTime->local($time, $format);
    }

    public function html(string $time, string $format = 'c') : string
    {
        return $this->escaper->html($this->raw($time, $format));
    }

    public function attr(string $time, string $format = 'c') : string
    {
        return $this->escaper->attr($this->raw($time, $format));
    }

    public function tag(string $time, string $format = 'c', array $attr = []) : string
    {
        $attr['datetime'] = $this->raw($time, 'c');
        $attr = $this->escaper->attr($attr);
        return "<time $attr>" . $this->html($time, $format) . '</time>';
    }
}
