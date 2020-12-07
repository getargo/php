<?php
declare(strict_types=1);

namespace Argo\App\Content\Draft;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Content\Draft\Draft;
use Argo\Domain\Content\Post\Post;
use Argo\Domain\DateTime;
use Argo\Domain\Exception;
use Argo\Domain\Storage;
use Argo\Infrastructure\BuildFactory;
use Argo\App\Payload;
use Argo\App\UseCase;

class PublishDraft extends UseCase
{
    protected $dateTime;

    protected $storage;

    protected $config;

    protected $content;

    protected $buildFactory;

    public function __construct(
        DateTime $dateTime,
        Storage $storage,
        Config $config,
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
        $this->content = $content;
        $this->buildFactory = $buildFactory;
    }

    // this is really more like save-and-publish draft
    protected function exec(string $relId, array $data, string $body) : Payload
    {
        $draft = $this->content->drafts->getItem($relId);

        if ($draft === null) {
            return Payload::notFound();
        }

        $draft->fill($data);
        $this->content->drafts->save($draft, $body);

        $name = Draft::normalize($draft->title ?? '');

        if ($name === '') {
            return Payload::invalid([
                'invalid' => "Cannot create post URL from draft title '{$draft->title}'"
            ]);
        }

        $date = $this->dateTime->ymd();
        $id = Post::absId("{$date}/{$name}");
        $post = new Post($id, (array) $draft->data);
        $post->data->created = null;
        $post->data->updated = [];

        if ($this->storage->exists($id)) {
            return Payload::invalid([
                'invalid' => "A post at '{$post->relId}' already exists."
            ]);
        }

        $this->storage->move($draft->id, $post->id);
        $this->content->posts->save($post, null);

        $this->buildFactory->new()->onePost($post, true);

        return Payload::created(['item' => $post]);
    }
}
