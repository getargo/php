<?php
declare(strict_types=1);

namespace Argo\Domain\App\Content\Page;

use Argo\Domain\Model\DateTime;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Infra\BuildFactory;
use Argo\Domain\Payload;
use Argo\Domain\App;

class SavePage extends App
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
