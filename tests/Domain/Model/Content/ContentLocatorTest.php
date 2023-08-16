<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content;

use Argo\Domain\Model\Content\Draft\DraftRepository;
use Argo\Domain\Model\Content\Page\PageRepository;
use Argo\Domain\Model\Content\Tag\TagRepository;
use Argo\Domain\Model\Content\Post\PostRepository;
use Argo\Domain\Storage;
use RuntimeException;

class ContentLocatorTest extends \Argo\Domain\TestCase
{
    /**
     * @dataProvider provideInstance
     */
    public function testInstance($name, $class) : void
    {
        $this->assertInstanceOf($class, $this->content->$name);
    }

    public function provideInstance()
    {
        return [
            ['drafts', DraftRepository::CLASS],
            ['tags', TagRepository::CLASS],
            ['pages', PageRepository::CLASS],
            ['posts', PostRepository::CLASS],
        ];
    }

    public function testInstanceFailure()
    {
        $this->expectDomainException("No such repository: nonesuch");
        $this->content->nonesuch;
    }
}
