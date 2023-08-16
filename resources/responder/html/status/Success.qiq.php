<?php
$this->setLayout(null);

$label = $this->request()->method->is('GET')
    ? 'Location'
    : 'X-Argo-Forward';

$this->response()->setHeader($label, '/');
