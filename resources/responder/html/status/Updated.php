<?php
$this->setLayout(null);
$this->response()->setCode(200);
$forward = "/{$this->item->type}/{$this->item->relId}/";
$this->response()->setHeader('X-Argo-Forward', $forward);
