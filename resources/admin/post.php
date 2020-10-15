<?php
use Argo\Http\Action\Post\DeletePost;
use Argo\Http\Action\Post\PostPost;
?>

<h1>Post</h1>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <table>
        <tr>
            <th align="right" valign="top">Title</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => $this->post->title,
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
                'value' => implode(', ', $this->post->tags),
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
                'value' => $this->post->author,
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top"></th>
            <td>
                <?= $this->routeSubmit(
                    'Save',
                    PostPost::CLASS,
                    $this->post->relId
                ); ?>

                <?= $this->anchorOpenFolder($this->post->id); ?>

                <span style="float: right;"><?= $this->routeSubmit(
                    'Trash',
                    DeletePost::CLASS,
                    $this->post->relId
                ); ?></span>
            </td>
        </tr>
    </table>
</form>

<hr />

<h2><?= $this->post->title ?></h2>
<?= $this->body($this->post); ?>
