<?php
use Argo\Http\Action\Draft\DeleteDraft;
use Argo\Http\Action\Draft\PostDraft;
use Argo\Http\Action\Draft\Publish\PostDraftPublish;
?>
<h1>Draft</h1>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <table>
        <tr>
            <th align="right" valign="top">Title</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => $this->draft->title,
                'attribs' => [
                    'style' => 'width: 100%;',
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Body</th>
            <td><?= $this->input([
                'type' => 'textarea',
                'name' => 'body',
                'value' => $this->body,
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Tags</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'tags',
                'value' => implode(', ', $this->draft->tags),
                'attribs' => [
                    'style' => 'width: 100%;',
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Author</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'author',
                'value' => $this->draft->author,
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top"></th>
            <td>
                <?= $this->routeSubmit(
                    'Save',
                    PostDraft::CLASS,
                    $this->draft->relId
                ); ?>

                <?= $this->routeSubmit(
                    'Publish',
                    PostDraftPublish::CLASS,
                    $this->draft->relId
                ); ?>

                <?= $this->anchorOpenFolder($this->draft->id); ?>

                <span style="float: right;"><?= $this->routeSubmit(
                    'Trash',
                    DeleteDraft::CLASS,
                    $this->draft->relId
                ); ?></span>
            </td>
        </tr>
    </table>
</form>

<hr />

<h2><?= $this->draft->title ?? '---' ?></h2>
<?= $this->body($this->draft); ?>
