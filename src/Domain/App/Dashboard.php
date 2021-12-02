<?php
declare(strict_types=1);

namespace Argo\Domain\App;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Storage;
use Argo\Domain\Payload;
use Argo\Domain\App;

class Dashboard extends App
{
    protected $system;

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

    protected function exec() : Payload
    {
        return Payload::found([
            'drafts' => $this->content->drafts->getItems(),
            'posts' => $this->content->posts->getItems(1, $this->config->general->perPage),
            'remote' => trim((string) $this->config->general->url),
        ]);
    }
}
