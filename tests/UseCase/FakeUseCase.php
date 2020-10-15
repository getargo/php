<?php
declare(strict_types=1);

namespace Argo\UseCase;

use Exception;

class FakeUseCase extends UseCase
{
    public function exec()
    {
        throw new Exception('fake error');
    }
}
