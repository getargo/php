<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'stderr');

use Argo\Infra\Preflight;
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Otto\Sapi\Http\Front;
use Sapien\Request;
use Sapien\Response;

try {

    require dirname(__DIR__) . "/vendor/autoload.php";

    $container = new Container(
        new Definitions(),
        require dirname(__DIR__) . "/config/providers.php"
    );

    $request = $container->get(Request::CLASS);
    $preflight = $container->get(Preflight::CLASS);
    $redirect = $preflight($request->url->path);

    if ($redirect !== null) {
        header("Location: {$redirect}");
        exit();
    }

    $front = $container->get(Front::CLASS);
    $response = $front();

} catch (Throwable $e) {

    $response = (new Response())
        ->setCode(500)
        ->setHeader('content-type', 'text/plain')
        ->setContent($e);

}

$response->send();
