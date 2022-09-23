<?php
$namespace = Argo::CLASS;
$directory = dirname(__DIR__);

return [
    new Otto\OttoProvider(
        namespace: $namespace,
        directory: $directory,
    ),
    new Otto\Infra\InfraProvider(
    ),
    new Argo\Infra\QiqProvider(),
    new Argo\Infra\InfraProvider(),
    new Otto\Sapi\Http\HttpProvider(
        format: 'html',
        layout: 'layout:main',
        helpers: [
            'anchorLocal' => Argo\View\Helper\AnchorLocal::CLASS,
            'anchorOpenFolder' => Argo\View\Helper\AnchorOpenFolder::CLASS,
            'body' => Argo\View\Helper\Body::CLASS,
            'bodyLess' => Argo\View\Helper\BodyLess::CLASS,
            'bodyPreview' => Argo\View\Helper\BodyPreview::CLASS,
            'dateTime' => Argo\View\Helper\DateTime::CLASS,
            'penders' => Argo\View\Helper\Penders::CLASS,
            'submitAction' => Argo\View\Helper\SubmitAction::CLASS,
        ],
    ),
];
