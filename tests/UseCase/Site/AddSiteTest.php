<?php
declare(strict_types=1);

namespace Argo\UseCase\Site;

class AddSiteTest extends \Argo\UseCase\TestCase
{
    public function testInitialSetup()
    {
        $payload = $this->invoke();
        $this->assertFound($payload);
        $this->assertEquals($payload->getResult(), [
            'name' => '',
            'title' => '',
            'tagline' => '',
            'author' => getenv('USER') ?: '',
            'url' => '',
        ]);
    }

    public function testInvalidInput()
    {
        $input = ['name' => '   '];
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The folder name may not be blank.');

        $input['name'] = '!!!';
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The folder name may use only a-z, 0-9, and dashes.');

        mkdir($this->system->sitesDir() . '/argo-test-prior');

        $input['name'] = 'argo-test-prior';
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, "A folder with the name 'argo-test-prior' already exists.");

        $input['name'] = 'argo-test';

        $input['title'] = '   ';
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The blog title may not be blank.');

        $input['title'] = 'Title Title';
        $input['author'] = '   ';

        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The author username may not be blank.');

        $input['author'] = '!!!';
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The author username may use only a-z, 0-9, and dashes.');

        $input['author'] = 'boshag';
        $input['url'] = '   ';
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The blog URL may not be blank.');

        $input['url'] = '/path/bar';
        $payload = $this->invoke($input);
        $this->assertInvalid($payload, 'The blog URL does not look right.');
    }

    public function testValidInput() : void
    {
        $this->assertFalse($this->storage->exists('_config/general.json'));

        $input = [
            'name' => 'argo-test',
            'title' => 'Title Title',
            'tagline' => 'Tagline tagline.',
            'author' => 'boshag',
            'url' => 'http://example.com'
        ];

        $payload = $this->invoke($input);

        $this->assertSuccess($payload);

        $ids = [
            '_argo/admin.json',
            // '_argo/blogroll.json',
            '_argo/general.json',
            // '_argo/menu.json',
            // '_argo/sync.json',
            // '_argo/theme.json',
            // '_argo/blogroll.json',
            // '_theme/',
            // '_trash/',
            // 'post/0001/02/03/sample-post/argo.json',
            // 'post/0001/02/03/sample-post/index.html',
            // 'post/0001/02/03/sample-post/index.json',
            // 'posts/month/0001/02/index.html',
            // 'posts/month/0001/02/index.json',
            // 'posts/months/index.html',
            // 'posts/months/index.json',
            // 'posts/months/index.shtml',
            // 'tag/general/atom.xml',
            // 'tag/general/argo.json',
            // 'tag/general/index.html',
            // 'tag/general/index.json',
            // 'tags/index.html',
            // 'tags/index.json',
            // 'tags/index.shtml',
            // 'theme/default/',
            // 'atom.xml',
            // 'blogroll.shtml',
            // 'index.html',
            // 'menu.shtml',
        ];

        foreach ($ids as $id) {
            $this->assertTrue($this->storage->exists($id), "$id does not exist");
        }
    }
}
