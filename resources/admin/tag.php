<?php
use Argo\Http\Action\Tag\PostTag;
use Argo\Http\Action\Tag\DeleteTag;

$this->header = 'Tag';
?>
<div class="card card-outline">
    <div class="card-header">
        <h4><?= $this->escape()->html($this->tag->relId); ?></h4>
    </div>
    <div class="card-body">
        <?= $this->render('item', [
            'item' => $this->tag,
            'routeSubmitPost' => PostTag::CLASS,
            'routeSubmitDelete' => DeleteTag::CLASS,
        ]); ?>
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4><?= $this->tag->title ?></h4>
        <?= $this->bodyPreview($this->tag); ?>
    </div>
</div>
