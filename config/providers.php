<?php
$namespace = Argo::CLASS;
$directory = dirname(__DIR__);

return [
    new Otto\OttoProvider(
        namespace: $namespace,
        directory: $directory,
    ),
    new Otto\Sapi\Http\HttpProvider(
        format: 'html',
        layout: 'layout:main',
    ),
    new Argo\ArgoProvider(),
];
