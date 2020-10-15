<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Content\Post\Post;
use Argo\Domain\Json;

class MonthTest extends \Argo\Domain\TestCase
{
    public function test() : void
    {
        $prev = null;
        $next = null;
        $months = [];
        $y = '2000';
        for ($m = 10; $m <= 12; $m++) {
            $ym = "{$y}-{$m}";
            $curr = new Month($ym, $this->dateTime->month($ym));
            $curr->setPrev($prev);
            if ($prev) {
                $prev->setNext($curr);
            }
            $prev = $curr;
            $months[$ym] = $curr;
        }

        $this->assertCount(3, $months);

        $this->assertSame(null,               $months['2000-10']->prev);
        $this->assertSame($months['2000-11'], $months['2000-10']->next);

        $this->assertSame($months['2000-10'], $months['2000-11']->prev);
        $this->assertSame($months['2000-12'], $months['2000-11']->next);

        $this->assertSame($months['2000-11'], $months['2000-12']->prev);
        $this->assertSame(null,               $months['2000-12']->next);

        $month = $months['2000-11'];

        $post = new Post('post/2000/11/22/foo', [], 'Body body body');
        $month->attachPost($post);
        $this->assertSame([$post], $month->posts);

        $expect = [
            'href' => '/posts/month/2000/11/',
            'title' => 'November 2000',
            'count' => 1
        ];
        $this->assertJsonEquals($expect, Json::encode($month));

        $expect += ['foo' => 'bar'];
        $this->assertJsonEquals($expect, $month->toJson(['foo' => 'bar']));
    }

    public function testGetAllFromPosts() : void
    {
        $posts = [];
        $y = '2000';

        for ($m = 10; $m <= 12; $m++) {
            for ($d = 20; $d < 30; $d++) {
                $id = Post::absId("{$y}/{$m}/{$d}/title-{$d}");
                $data = [
                    'title' => "Title {$d}",
                    'tags' => [
                        'foo',
                    ],
                ];
                $posts[] = new Post($id, $data);
            }
        }

        $actual = Month::getAllFromPosts($posts, $this->dateTime);
        $this->assertCount(3, $actual);

        $this->assertCount(10, $actual['2000-10']->posts);
        $this->assertCount(10, $actual['2000-11']->posts);
        $this->assertCount(10, $actual['2000-12']->posts);
    }
}
