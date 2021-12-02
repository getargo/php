<?php
declare(strict_types=1);

namespace Argo\Domain\App\Import;

use SapiUpload;

class ImportTest extends \Argo\Domain\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testError() : void
    {
        $file = __DIR__ . '/wordpress.export.xml';
        $upload = new SapiUpload(
            basename($file),
            'application/xml',
            filesize($file),
            $file,
            UPLOAD_ERR_PARTIAL
        );

        $payload = $this->invoke($upload);
        $this->assertError($payload, "The uploaded file was only partially uploaded.");
    }

    public function testSuccess() : void
    {
        $file = __DIR__ . '/wordpress.export.xml';
        $upload = new SapiUpload(
            basename($file),
            'application/xml',
            filesize($file),
            $file,
            0
        );

        $payload = $this->invoke($upload);
        $this->assertProcessing($payload);
    }
}
