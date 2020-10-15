<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\Domain\Content\Item;
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

        return $this->expandImgSrc($item, $html);
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
            $src = $imgNode->attributes->getNamedItem('src');

            if (strpos($src->nodeValue, '://') !== false) {
                continue;
            }

            if (substr($src->nodeValue, 0, 2) === './') {
                $src->nodeValue = $item->href . substr($src->nodeValue, 2);
                continue;
            }

            if (substr($src->nodeValue, 0, 1) !== '/') {
                $src->nodeValue = $item->href . $src->nodeValue;
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
}
