<?php
$namespace = Argo::CLASS;
$directory = dirname(__DIR__);

return [
    new Argo\Infra\QiqProvider(),
    new Argo\Infra\InfraProvider(),
    new Otto\Sapi\Http\HttpProvider(
        namespace: $namespace,
        directory: $directory,
        responseFormat: 'html',
        responseLayout: 'layout:main',
        responseHelpers: [
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
