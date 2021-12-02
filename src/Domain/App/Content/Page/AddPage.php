<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Page;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\Content\Page\Page;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Json;
use Argo\Domain\Storage;
use Argo\Domain\Payload;
use Argo\Domain\App;

class AddPage extends App
{
    protected $storage;

    protected $config;

    protected $content;

    public function __construct(
        Storage $storage,
        ConfigMapper $config,
        ContentLocator $content
    ) {
        $this->storage = $storage;
        $this->config = $config;
        $this->content = $content;
    }

    protected function exec(string $id) : Payload
    {
        $id = trim($id, '/ ');
        Page::assertId($id);

        if ($this->storage->exists($id)) {
            return Payload::invalid([
                'invalid' => "Page {$id} already exists.",
            ]);
        }

        $parent = '';
        $parts = explode('/', $id);
        array_pop($parts);

        while (! empty($parts)) {
            $parent = implode('/', $parts);
            $file = $parent . '/argo.json';

            if (! $this->storage->exists($file)) {
                return Payload::invalid([
                    'invalid' => "Cannot create page '{$id}' without parent page '{$parent}' first.",
                ]);
            }

            array_pop($parts);
        }

        $data = [
            'title' => Page::titleize($id),
            'author' => $this->config->general->author,
            'tags' => [],
        ];

        $page = new Page($id, $data);
        $this->content->pages->save($page, '');

        // @todo build the page

        return Payload::created(['item' => $page]);
    }
}
