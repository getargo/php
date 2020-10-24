<?php
use Argo\Http\Action\Page\DeletePage;
use Argo\Http\Action\Page\PostPage;
?>

<h1>Page</h1>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <table>
        <tr>
            <th align="right" valign="top">Title</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => $this->page->title,
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
            <th align="right" valign="top">Markup</th>
            <td><?= $this->input([
                'type' => 'select',
                'name' => 'markup',
                'value' => $this->page->markup,
                'options' => [
                    'html' => 'HTML',
                    'markdown' => 'Markdown',
                    'wordpress' => 'WordPress',
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Author</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'author',
                'value' => $this->page->author,
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top"></th>
            <td>
                <?= $this->routeSubmit(
                    'Save',
                    PostPage::CLASS,
                    $this->page->id
                ); ?>

                <?= $this->anchorOpenFolder($this->page->id); ?>

                <span style="float: right;"><?= $this->routeSubmit(
                    'Trash',
                    DeletePage::CLASS,
                    $this->page->id
                ); ?></span>
            </td>
        </tr>
    </table>
</form>

<hr />

<h2><?= $this->page->title ?></h2>
<?= $this->body($this->page, 'http://127.0.0.1:8081'); ?>
