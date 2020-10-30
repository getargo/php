<?php
use Argo\Http\Action\Draft\DeleteDraft;
use Argo\Http\Action\Draft\PostDraft;

$this->header = 'Draft';
?>
<div class="card card-outline">
    <div class="card-body">
        <?= $this->render('item', [
            'item' => $this->draft,
            'routeSubmitPost' => PostDraft::CLASS,
            'routeSubmitDelete' => DeleteDraft::CLASS,
        ]); ?>
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h2><?= $this->draft->title ?? '---' ?></h2>
        <?= $this->bodyPreview($this->draft); ?>
    </div>
</div>
