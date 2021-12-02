<?php
declare(strict_types=1);

namespace Argo\Domain\App;

class FakeUseCaseTest extends \Argo\Domain\App\TestCase
{
    public function test()
    {
        $payload = $this->invoke();
        $this->assertError($payload, 'fake error');
    }
}
