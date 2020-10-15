<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\Draft\DraftRepository;
use Argo\Domain\Content\Page\PageRepository;
use Argo\Domain\Content\Post\PostRepository;
use Argo\Domain\Content\Tag\TagRepository;
use Argo\Domain\DateTime;
use Argo\Domain\Exception;
use Argo\Domain\Storage;

class ContentLocator
{
    protected $config;

    protected $dateTime;

    protected $storage;

    protected $instances = [
        'drafts' => DraftRepository::CLASS,
        'tags' => TagRepository::CLASS,
        'pages' => PageRepository::CLASS,
        'posts' => PostRepository::CLASS,
    ];

    public function __construct(
        DateTime $dateTime,
        Storage $storage,
        Config $config
    ) {
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
    }

    public function __get($key)
    {
        if (! isset($this->instances[$key])) {
            throw new Exception("No such repository: $key");
        }

        if (is_string($this->instances[$key])) {
            $this->instances[$key] = $this->new($this->instances[$key]);
        }

        return $this->instances[$key];
    }

    protected function new(string $class)
    {
        return new $class($this->dateTime, $this->storage, $this->config, $this);
    }
}
