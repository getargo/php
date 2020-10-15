<?php
declare(strict_types=1);

namespace Argo\UseCase;

use Argo\Domain\Exception\Invalid;
use Throwable;

abstract class UseCase
{
    public function __invoke(/* mixed */ ...$args) : Payload
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
