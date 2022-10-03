<?php
declare(strict_types=1);

namespace Argo\App;

class FakeUseCaseTest extends \Argo\App\TestCase
{
    public function test()
    {
        $payload = $this->invoke();
        $this->assertError($payload, 'fake error');
    }
}
