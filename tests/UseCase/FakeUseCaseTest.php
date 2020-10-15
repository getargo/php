<?php
declare(strict_types=1);

namespace Argo\UseCase;

class FakeUseCaseTest extends \Argo\UseCase\TestCase
{
    public function test()
    {
        $payload = $this->invoke();
        $this->assertError($payload, 'fake error');
    }
}
