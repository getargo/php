<?php
declare(strict_types=1);

namespace Argo\Infra\Build;

use Argo\Domain\Model\Content\Item;
use Otto\Sapi\Http\Template\Helpers as OttoHelpers;

class Helpers extends OttoHelpers
{
    public function dateTime(string $time, string $format = 'c') : string
    {
        return $this
            ->get(Helper\DateTime::class)
            ->__invoke($time, $format);
    }

    public function body(Item $item) : string
    {
        return $this
            ->get(Helper\Body::class)
            ->__invoke($item);
    }

    public function bodyLess(Item $item) : string
    {
        return $this
            ->get(Helper\BodyLess::class)
            ->__invoke($item);
    }

    public function penders(Template $tpl, string $type) : string
    {
        return $this
            ->get(Helper\Penders::class)
            ->__invoke($tpl, $type);
    }
}
