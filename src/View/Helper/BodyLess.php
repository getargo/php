<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\Domain\Content\Item;

class BodyLess extends Body
{
    protected function moreOrLess(Item $item, string $html) : string
    {
        $found = preg_match('/(.*)\n+\s*\<\!--\s*more\s*--\>\s*\n+(.*)/ms', $html, $matches);
        if ($found) {
            $html = $matches[1];
            $html .= "\n<p class=\"read-more\"><a class=\"read-more\" href=\"{$item->href}#more\">Read more</a></p>\n";
        }

        return $html;
    }
}
