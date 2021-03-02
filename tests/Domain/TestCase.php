<?php
declare(strict_types=1);

namespace Argo\Domain;

abstract class TestCase extends \Argo\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        $this->config->save($this->config->new('_argo/general', (object) [
            'perPage' => 10,
            'author' => 'boshag',
        ]));
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
