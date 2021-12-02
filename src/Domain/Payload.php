<?php
declare(strict_types=1);

namespace Argo\Domain;

use PayloadInterop\DomainPayload;

class Payload implements DomainPayload
{
    protected $status;

    protected $result;

    public function __construct(string $status, array $result)
    {
        $this->status = $status;
        $this->result = $result;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function getResult() : array
    {
        return $this->result;
    }

    public static function created(array $result = []) : Payload
    {
        return new Payload(Status::CREATED, $result);
    }

    public static function deleted(array $result = []) : Payload
    {
        return new Payload(Status::DELETED, $result);
    }

    public static function notFound(array $result = []) : Payload
    {
        return new Payload(Status::NOT_FOUND, $result);
    }

    public static function found(array $result = []) : Payload
    {
        return new Payload(Status::FOUND, $result);
    }

    public static function invalid(array $result = []) : Payload
    {
        return new Payload(Status::INVALID, $result);
    }

    public static function success(array $result = []) : Payload
    {
        return new Payload(Status::SUCCESS, $result);
    }

    public static function updated(array $result = []) : Payload
    {
        return new Payload(Status::UPDATED, $result);
    }

    public static function error(array $result = []) : Payload
    {
        return new Payload(Status::ERROR, $result);
    }

    public static function processing(array $result = []) : Payload
    {
        return new Payload(Status::PROCESSING, $result);
    }

    public static function accepted(array $result = []) : Payload
    {
        return new Payload(Status::ACCEPTED, $result);
    }
}
