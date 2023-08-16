<?php
$this->setLayout(null);

// newly-created posts go back to the dashboard;
// everything else goes to its own editing page
$forward = ($item->type === 'post')
    ? '/'
    : "/{$item->type}/{$item->relId}/";
$this->response()->setHeader('X-Argo-Forward', $forward);
