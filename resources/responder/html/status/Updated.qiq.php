<?php
$this->setLayout(null);
$this->response()->setCode(200);
$forward = "/{$item->type}/{$item->relId}/";
$this->response()->setHeader('X-Argo-Forward', $forward);
