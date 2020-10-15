<?php
use Argo\Http\Action\Tag\GetTag;
use Argo\Http\Action\Tag\Add\PostTagAdd;
?>
<h1>Tags</h1>

<h2>Create New Tag</h2>

<form onsubmit="return false;">
    <p>
        <label>Name: <?= $this->input([
            'type' => 'text',
            'name' => 'relId',
            'value' => '',
            'attribs' => [
                'size' => 60,
            ],
        ]); ?></label>

        <?= $this->routeSubmit(
            'Create',
            PostTagAdd::CLASS
        ); ?>
    </p>

    <div id="submit-failure"></div>
</form>

<h3>Existing Tags</h3>
<table>
    <tr>
        <th>Name</th>
        <th>Title</th>
        <th></th>
    </tr>
    <?php foreach ($this->tags as $tag): ?>
    <tr valign="top">
        <td><?= $this->escape()->html($tag->relId); ?></td>
        <td><?= $this->escape()->html($tag->title); ?></td>
        <td><?= $this->anchor(
            $this->route(GetTag::CLASS, $tag->relId),
            'Edit'
        ); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
