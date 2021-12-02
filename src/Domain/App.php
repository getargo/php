<?php
declare(strict_types=1);

namespace Argo\Domain;

use Argo\Domain\Exception\Invalid;
use Throwable;

abstract class App
{
    public function __invoke(mixed ...$args) : Payload
    {
        try {
            return $this->exec(...$args);
        } catch (Invalid $e) {
            $args['invalid'] = $e->getMessage();
            return Payload::invalid($args);
        } catch (Throwable $e) {
            $args['error'] = (string) $e;
            return Payload::error($args);
        }
    }
}
