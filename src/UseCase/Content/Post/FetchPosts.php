<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Post;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class FetchPosts extends UseCase
{
    protected $config;

    protected $content;

    public function __construct(Config $config, ContentLocator $content)
    {
        $this->config = $config;
        $this->content = $content;
    }

    protected function exec(int $pageNum) : Payload
    {
        $perPage = $this->config->general->perPage;
        $posts = $this->content->posts->getItems($pageNum, $perPage);

        if (empty($posts)) {
            return Payload::notFound();
        }

        list($itemCount, $pageCount) = $this->content->posts->listCounts($perPage);
        $output = [
            'pageNum' => $pageNum,
            'pageCount' => $pageCount,
            'posts' => $posts,
        ];

        return Payload::found($output);
    }
}
