<?php
declare(strict_types=1);

namespace Argo\App\Content\Post;

use Argo\Domain\Config\ConfigMapper;
use Argo\Domain\Content\ContentLocator;
use Argo\App\Payload;
use Argo\App\UseCase;

class FetchPosts extends UseCase
{
    protected $config;

    protected $content;

    public function __construct(ConfigMapper $config, ContentLocator $content)
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
