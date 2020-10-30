<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\Domain\Content\Item;
use DomDocument;
use DomXpath;

class BodyPreview extends Body
{
    protected function moreOrLess(Item $item, string $html) : string
    {
        return $html;
    }

    protected function href(string $href) : string
    {
        return 'http://127.0.0.1:8081' . $href;
    }

    protected function retargetAnchor(Item $item, string $html) : string
    {
        $doc = new DomDocument();
        $doc->formatOutput = true;
        $doc->loadHtml(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING
        );

        $xpath = new DomXpath($doc);
        $query = '//a';
        $aNodes = $xpath->query($query);

        foreach ($aNodes as $aNode) {
            $aNode->setAttribute('target', '_blank');
            $href = $aNode->getAttribute('href');

            if (strpos($href, '://') !== false) {
                continue;
            }

            if (substr($href, 0, 2) === './') {
                $aNode->setAttribute('href', $this->href($item->href . substr($href, 2)));
                continue;
            }

            if (substr($href, 0, 1) === '/') {
                $aNode->setAttribute('href', $this->href($href));
                continue;
            }

            if (substr($href, 0, 1) !== '/') {
                $aNode->setAttribute('href', $this->href($item->href . $href));
            }
        }

        // retain the modified html
        $html = trim($doc->saveHtml($doc->documentElement));

        // strip the html and body tags added by DomDocument
        $html = substr(
            $html,
            strlen('<html><body>'),
            -1 * strlen('</body></html>')
        );

        // still may be whitespace all about
        return trim($html) . PHP_EOL;
    }
}
