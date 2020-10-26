<?php
use Argo\Http\Action\Tag\PostTag;

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
            // 'routeSubmitDelete' => DeleteTag::CLASS,
        ]); ?>
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4><?= $this->tag->title ?></h4>
        <?= $this->body($this->tag, 'http://127.0.0.1:8081'); ?>
    </div>
</div>
