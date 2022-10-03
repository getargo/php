<?php
declare(strict_types=1);

namespace Argo\App;

use Exception;

class FakeUseCase extends App
{
    public function exec()
    {
        throw new Exception('fake error');
    }
}
