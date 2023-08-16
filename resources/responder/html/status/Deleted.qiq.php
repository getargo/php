<?php
$this->setLayout(null);
$forward = in_array($item->type, ['draft', 'post'])
    ? '/'
    : "/{$item->type}s/";
$this->response()->setHeader('X-Argo-Forward', $forward);
