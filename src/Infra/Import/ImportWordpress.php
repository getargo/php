<?php
declare(strict_types=1);

namespace Argo\Infra\Import;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Infra\Log;
use Argo\Domain\Storage;
use DomDocument;
use DomXpath;

class ImportWordpress
{
    protected $content;

    protected $log;

    protected $urls = [];

    public function __construct(
        Storage $storage,
        ContentLocator $content,
        Log $log
    ) {
        $this->storage = $storage;
        $this->content = $content;
        $this->log = $log;
    }

    public function __invoke(string $file) : void
    {
        $xml = simplexml_load_file($file);
        $wp = $this->getNamespaceChildren($xml->channel, 'wp');
        $this->urls = array_unique([
            (string) $xml->channel->link,
            (string) $wp->base_site_url,
            (string) $wp->base_blog_url,
        ]);

        foreach ($xml->channel->item as $wpItem) {
            $this->importItem($wpItem);
        }
    }

    protected function importItem($wpItem)
    {
        $wp = $this->getNamespaceChildren($wpItem, 'wp');
        $dc = $this->getNamespaceChildren($wpItem, 'dc');
        $content = $this->getNamespaceChildren($wpItem, 'content');
        $excerpt = $this->getNamespaceChildren($wpItem, 'excerpt');

        list($type, $id) = $this->listTypeId($wp);
        if ($type === null) {
            return;
        }

        if ($this->storage->exists($id)) {
            $this->log->echo("SKIP {$id} (already exists)");
            return;
        }

        $uctype = ucfirst($type);
        $class = "Argo\Domain\Model\Content\\{$uctype}\\{$uctype}";
        $item = new $class($id);
        $data = [
            'title' => (string) $wpItem->title,
            'author' => (string) $dc->creator,
            'markup' => 'wordpress',
            'tags' => [],
        ];

        $tags = [];

        foreach ($wpItem->category as $category) {
            // covers all category domains, incl "category" and "post_tag"
            $tags[] = (string) $category['nicename'];
        }

        $data['tags'] = array_unique($data['tags']);

        $item->fill($data);

        $item->data->created = $wp->post_date_gmt . ' UTC';
        $item->data->updated = [$wp->post_date_gmt . ' UTC'];

        $body = (string) $content->encoded;

        $this->log->echo("save {$id}");
        $repo = "{$type}s";
        $this->content->$repo->save($item, $body);

        $this->importItemImages($body);
    }

    protected function listTypeId(object $wp) : array
    {
        $type = (string) $wp->post_type;

        if ($type !== 'page' && $type !== 'post') {
            return [null, null];
        }

        $name = (string) $wp->post_name;

        if (empty($name)) {
            return [null, null];
        }

        $id = str_replace('_', '-', $name);

        if ($type === 'post') {
            list($date, $time) = explode(' ', (string) $wp->post_date);
            $id = "post/"
                . str_replace('-', '/', $date)
                . "/{$id}";
        }

        return [$type, $id];
    }

    protected function getNamespaceChildren($xml, string $namespace)
    {
        $ns = $xml->getNamespaces(true);
        return $xml->children($ns[$namespace]);
    }

    protected function importItemImages(string $body)
    {
        $doc = new DomDocument();
        $doc->formatOutput = true;
        $doc->loadHtml(
            mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING
        );

        $xpath = new DomXpath($doc);
        $query = '//img';
        $imgNodes = $xpath->query($query);

        foreach ($imgNodes as $imgNode) {
            $src = $imgNode->attributes->getNamedItem('src');
            $this->importItemImage($src);
        }
    }

    protected function importItemImage($src) : void
    {
        $remote = $src->nodeValue;

        foreach ($this->urls as $url) {
            if (strpos($remote, '://') === false) {
                $remote = $url . $remote;
            }

            if (strpos($remote, $url) === false) {
                continue;
            }

            $data = $this->fileGetContents($remote);

            if ($data === false) {
                $this->log->echo("FAIL image {$remote}");
                continue;
            }

            $local = substr($remote, strlen($url));
            $local = ltrim($local, '/');

            $this->storage->forceDir(dirname($local));
            $file = $this->storage->path($local);

            file_put_contents($file, $data);
            $this->log->echo('save image ' . $local);
            return;
        }
    }

    protected function fileGetContents($file)
    {
        return @file_get_contents($file);
    }
}
