<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\Domain\Model\Content\Item;
use Argo\Domain\Storage;
use DomDocument;
use DomXpath;

class Body
{
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(Item $item) : string
    {
        $body = $this->storage->read($item->getBodyFile());

        $body = trim($body);
        if ($body === '') {
            return $body;
        }

        $markup = $item->data->markup ?? 'markdown';
        $class = 'Argo\View\Helper\Body\\' . ucfirst($markup);
        $convert = new $class();
        $html = $convert->toHtml($body);
        $html = $this->expandImgSrc($item, $html);
        $html = $this->retargetAnchor($item, $html);
        $html = $this->moreOrLess($item, $html);
        return $html;
    }

    protected function moreOrLess(Item $item, string $html) : string
    {
        $found = preg_match('/(.*)\n+\s*\<\!--\s*more\s*--\>\s*\n+(.*)/ms', $html, $matches);
        if ($found) {
            $html = $matches[1] . "\n\n<a id=\"more\"</a>\n\n" . $matches[2];
        }
        return $html;
    }

    protected function retargetAnchor(Item $item, string $html) : string
    {
        return $html;
    }

    protected function expandImgSrc(Item $item, string $html) : string
    {
        $doc = new DomDocument();
        $doc->formatOutput = true;
        $doc->loadHtml(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING
        );

        $xpath = new DomXpath($doc);
        $query = '//img';
        $imgNodes = $xpath->query($query);

        foreach ($imgNodes as $imgNode) {
            $src = $imgNode->getAttribute('src');

            if (strpos($src, '://') !== false) {
                continue;
            }

            if (substr($src, 0, 2) === './') {
                $imgNode->setAttribute('src', $this->href($item->href . substr($src, 2)));
                continue;
            }

            if (substr($src, 0, 1) === '/') {
                $imgNode->setAttribute('src', $this->href($src));
                continue;
            }

            if (substr($src, 0, 1) !== '/') {
                $imgNode->setAttribute('src', $this->href($item->href . $src));
                continue;
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

    protected function href(string $href) : string
    {
        return $href;
    }
}
