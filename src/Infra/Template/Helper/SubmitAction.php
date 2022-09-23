<?php
declare(strict_types=1);

namespace Argo\Infra\Template\Helper;

use AutoRoute\Helper as RouteHelper;
use Qiq\Helper\Button;

class SubmitAction
{
    protected $route;

    protected $button;

    public function __construct(
        RouteHelper $route,
        Button $button
    ) {
        $this->route = $route;
        $this->button = $button;
    }

    public function __invoke(string $value, string $class, ...$params) : string
    {
        $parts = explode('\\', $class);
        $last = end($parts);
        preg_match('/^(.+?)[A-Z]/', $last, $matches);
        $method = strtoupper($matches[1]);
        $route = ($this->route)($class, ...$params);

        return ($this->button)([
            'name' => strtolower(str_replace(' ', '_', $value)),
            'value' => $value,
            'onclick' => "xhrSubmit('{$method}', this.form, '{$route}'); return false;"
        ]);
    }
}
