<?php
declare(strict_types=1);

namespace Argo\App;

class OpenFolderTest extends \Argo\App\TestCase
{
    public function testError()
    {
        $folder = 'no-such-folder';
        $payload = $this->invoke($folder);
        $this->assertError($payload, "no-such-folder' not found.");
    }

    public function testProcessing()
    {
        $this->setUpArgo();

        $folder = '_trash';
        $payload = $this->invoke($folder);
        $this->assertAccepted($payload);
    }
}
