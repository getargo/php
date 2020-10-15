<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Post;

use Argo\Domain\Content\Post\Post;
use Argo\Infrastructure\BuildFactory;

class FetchPostsTest extends \Argo\UseCase\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();

        $samplePost = $this->content->posts->getItem('0001/02/03/sample-post');
        $this->content->posts->trash($samplePost);

        for ($i = 10; $i < 40; $i ++) {
            $date = $this->dateTime->ymd();
            $this->post = new Post(
                Post::absId("{$date}/title-{$i}"),
                [
                    'title' => "Title {$i}",
                    'author' => 'boshag',
                    'tags' => 'general',
                ]
            );
            $this->content->posts->save($this->post, "Body {$i}.");
            $this->modDateTimeNow("+10 minutes");
        }
        $this->container->get(BuildFactory::CLASS)->new()->all();
    }

    public function test() : void
    {
        for ($i = 1; $i < 4; $i ++) {
            $payload = $this->invoke($i);
            $this->assertFound($payload);
            $result = $payload->getResult();
            $this->assertEquals($i, $result['pageNum']);
            // $this->assertEquals(4, $result['pageCount']);
            $this->assertCount(10, $result['posts']);
        }

        $payload = $this->invoke(4);
        $this->assertNotFound($payload);
    }
}
