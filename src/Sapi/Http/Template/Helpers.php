<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Template;

use Argo\Domain\Model\Content\Item;
use Argo\Infra\Build\Helper\DateTime;
use Otto\Sapi\Http\Template\Helpers as OttoHelpers;

class Helpers extends OttoHelpers
{
    public function anchorLocal(string $href, string $text, array $attr = [], mixed ...$__attr) : string
    {
        return $this
            ->get(Helper\AnchorLocal::class)
            ->__invoke($href, $text, $attr, ...$__attr);
    }

    public function anchorOpenFolder(string $id, string $text = 'Open Folder') : string
    {
        return $this
            ->get(Helper\AnchorOpenFolder::class)
            ->__invoke($id, $text);
    }

    public function anchorAction(string $text, string $class, ...$params) : string
    {
        return $this->anchor(
            $this->action($class, ...$params),
            $text
        );
    }

    public function bodyPreview(Item $item) : string
    {
        return $this
            ->get(Helper\BodyPreview::class)
            ->__invoke($item);
    }

    public function dateTime(string $time, string $format = 'c') : string
    {
        return $this
            ->get(DateTime::class)
            ->__invoke($time, $format);
    }

    public function formAction(string $class, ...$params) : string
    {
        $tail = strrchr($class, '\\');

        $method = substr($tail, 1, 3) === 'Get'
            ? 'get'
            : 'post';

        return $this->form(
            method: $method,
            action: $this->action($class, ...$params)
        );
    }

    public function submitAction(string $value, string $class, ...$params) : string
    {
        return $this
            ->get(Helper\SubmitAction::class)
            ->__invoke($value, $class, ...$params);
    }
}
