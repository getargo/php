<?php
$this->setLayout(null);

// newly-created posts go back to the dashboard;
// everything else goes to its own editing page
$forward = ($this->item->type === 'post')
    ? '/'
    : "/{$this->item->type}/{$this->item->relId}/";
$this->response()->setHeader('X-Argo-Forward', $forward);
