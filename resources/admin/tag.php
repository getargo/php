<?php
use Argo\Http\Action\Tag\PostTag;
?>
<h1>Tag</h1>
<h2><?= $this->escape()->html($this->tag->relId); ?></h2>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <table>
        <tr>
            <th align="right" valign="top">Title</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => $this->tag->title,
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
            <th align="right" valign="top"></th>
            <td>
                <?= $this->routeSubmit(
                    'Save',
                    PostTag::CLASS,
                    $this->tag->relId
                ); ?>

                <?= $this->anchorOpenFolder($this->tag->id); ?>
            </td>
        </tr>
    </table>
</form>

<hr />

<h2><?= $this->tag->title ?></h2>
<?= $this->body($this->tag); ?>
