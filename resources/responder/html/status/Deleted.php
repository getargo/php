<?php
$this->setLayout(null);
$forward = in_array($this->item->type, ['draft', 'post'])
    ? '/'
    : "/{$this->item->type}s/";
$this->response()->setHeader('X-Argo-Forward', $forward);
