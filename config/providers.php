<?php
$namespace = Argo::CLASS;
$directory = dirname(__DIR__);

return [
    new Otto\OttoProvider(
        namespace: $namespace,
        directory: $directory,
    ),
    new Otto\Infra\InfraProvider(),
    new Argo\Infra\InfraProvider(),
    new Otto\Sapi\Http\HttpProvider(
        format: 'html',
        layout: 'layout:main',
        helpers: [
            'anchorLocal' => Argo\Infra\Template\Helper\AnchorLocal::CLASS,
            'anchorOpenFolder' => Argo\Infra\Template\Helper\AnchorOpenFolder::CLASS,
            'bodyPreview' => Argo\Infra\Template\Helper\BodyPreview::CLASS,
            'dateTime' => Argo\Infra\Template\Helper\DateTime::CLASS,
            'submitAction' => Argo\Infra\Template\Helper\SubmitAction::CLASS,
        ],
    ),
];
