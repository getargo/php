<?php
declare(strict_types=1);

namespace Argo\Domain;

use Argo\Domain\Config\Values\General;

abstract class TestCase extends \Argo\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        $this->config->general = new General((object) [
            'perPage' => 10,
            'author' => 'boshag',
        ]);
    }

    protected function expectDomainException(string $message) : void
    {
        $this->expectException(Exception::CLASS);
        $this->expectExceptionMessage($message);
    }

    protected function expectInvalidData(string $message) : void
    {
        $this->expectException(Exception\InvalidData::CLASS);
        $this->expectExceptionMessage($message);
    }

    protected function expectInvalidJson() : void
    {
        $this->expectException(Exception\InvalidJson::CLASS);
    }
}
