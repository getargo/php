<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Argo\View\Helper\Route;
use Aura\Html\Helper\Input;
use Aura\Html\Helper\Input\Generic;

class RouteSubmit
{
    protected $route;

    protected $input;

    public function __construct(
        Route $route,
        Input $input
    ) {
        $this->route = $route;
        $this->input = $input;
    }

    public function __invoke(string $value, string $class, ...$params) : Generic
    {
        $parts = explode('\\', $class);
        $last = end($parts);
        preg_match('/^(.+?)[A-Z]/', $last, $matches);
        $method = strtoupper($matches[1]);

        $route = ($this->route)($class, ...$params);
        return ($this->input)([
            'type' => 'button',
            'name' => strtolower(str_replace(' ', '_', $value)),
            'value' => $value,
            'attribs' => [
                'onclick' => "xhrSubmit('{$method}', this.form, '{$route}'); return false;"
            ]
        ]);
    }
}
