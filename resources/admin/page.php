<?php
use Argo\Http\Action\Page\DeletePage;
use Argo\Http\Action\Page\PostPage;

$this->header = 'Page';
?>
<div class="card card-outline">
    <div class="card-body">
        <?= $this->render('item', [
            'item' => $this->page,
            'routeSubmitPost' => PostPage::CLASS,
            'routeSubmitDelete' => DeletePage::CLASS,
        ]); ?>
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h3><?= $this->page->title ?></h3>
        <?= $this->bodyPreview($this->page); ?>
    </div>
</div>
