<?php
declare(strict_types=1);

namespace Argo\App\Content\Page;

use Argo\Domain\DateTime;
use Argo\Domain\Content\ContentLocator;
use Argo\Infra\BuildFactory;
use Argo\App\Payload;
use Argo\App\UseCase;

class SavePage extends UseCase
{
    protected $content;

    protected $buildFactory;

    public function __construct(
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->content = $content;
        $this->buildFactory = $buildFactory;
    }

    protected function exec(string $id, array $data, string $body) : Payload
    {
        $page = $this->content->pages->getItem($id);

        if ($page === null) {
            return Payload::notFound();
        }

        $page->fill($data);
        $this->content->pages->save($page, $body);
        $this->buildFactory->new()->onePage($page);

        return Payload::updated(['item' => $page]);
    }
}
