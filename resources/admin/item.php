<?php
use Argo\Domain\Content\Tag\Tag;
use Argo\Domain\Content\Draft\Draft;
use Argo\Http\Action\Draft\Publish\PostDraftPublish;
?>
<form onsubmit="return false;">

    <div id="submit-failure"></div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label>URL</label>
        </div>
        <div class="col"><?= $this->escape()->html($item->href) ?></div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="title">Title</label>
        </div>
        <div class="col">
            <?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => $item->title,
                'attribs' => [
                    'class' => 'form-control',
                ],
            ]); ?>
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="body">Body</label>
        </div>
        <div class="col">
            <?= $this->input([
                'type' => 'textarea',
                'name' => 'body',
                'value' => $this->body,
                'attribs' => [
                    'class' => 'form-control h-100',
                    'style' => 'font-size: 85%;',
                    'rows' => '12',
                ],
            ]); ?>
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="markup">Markup</label>
        </div>
        <div class="col">
            <?= $this->input([
                'type' => 'select',
                'name' => 'markup',
                'value' => $item->markup,
                'options' => [
                    'html' => 'HTML',
                    'markdown' => 'Markdown',
                    'wordpress' => 'WordPress',
                ],
                'attribs' => [
                    'class' => 'form-control',
                ],
            ]); ?>
        </div>
    </div>

    <?php if (! $item instanceof Tag): ?>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="tags">Tags</label>
        </div>
        <div class="col">
            <?= $this->input([
                'type' => 'text',
                'name' => 'tags',
                'value' => implode(', ', $item->tags),
                'attribs' => [
                    'class' => 'form-control',
                ],
            ]); ?>
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="author">Author</label>
        </div>
        <div class="col">
            <?= $this->input([
                'type' => 'text',
                'name' => 'author',
                'value' => $item->author,
                'attribs' => [
                    'class' => 'form-control',
                ],
            ]); ?>
        </div>
    </div>

    <?php endif; ?>

    <div class="row mb-1 align-items-start">
        <div class="col col-1">
        </div>
        <div class="col">
            <?= $this->routeSubmit(
                'Save',
                $routeSubmitPost,
                $item->relId
            ); ?>

            <?php if ($item instanceof Draft): ?>

            <?= $this->routeSubmit(
                'Publish',
                PostDraftPublish::CLASS,
                $this->draft->relId
            ); ?>

            <?php endif; ?>

            <?= $this->anchorOpenFolder($item->id); ?>

            <span style="float: right;"><?= $this->routeSubmit(
                'Trash',
                $routeSubmitDelete,
                $item->relId
            ); ?></span>

        </div>
    </div>
</form>
