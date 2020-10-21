<?php
declare(strict_types=1);

namespace Argo\UseCase\Import;

use Argo\Infrastructure\BuildFactory;
use Argo\Infrastructure\Import\ImportWordpress;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;
use SapiUpload;

class Import extends UseCase
{
    protected $errors = [
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload.",
    ];

    public function __construct(ImportWordpress $import, BuildFactory $buildFactory)
    {
        $this->import = $import;
        $this->buildFactory = $buildFactory;
    }

    protected function exec(SapiUpload $upload) : Payload
    {
        if ($upload->error !== 0) {
            return Payload::error([
                'error' => $this->errors[$upload->error] ?? 'Unknown upload error.',
            ]);
        }

        return Payload::processing([
            'callable' => function () use ($upload) {
                $old = ini_get('max_execution_time');
                ini_set('max_execution_time', '0');

                ($this->import)($upload->tmpName);
                $this->buildFactory->new('echo')->all();

                ini_set('max_execution_time', $old);
            },
        ]);
    }
}
