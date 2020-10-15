<?php
use Argo\Http\Action\Page\GetPage;
use Argo\Http\Action\Page\Add\PostPageAdd;
use Argo\Http\Action\Pages\GetPages;
?>
<h1>Pages</h1>

<h2>New Page</h2>

<form onsubmit="return false;">
    <p>
        <label>Create New Page At: <?= $this->input([
            'type' => 'text',
            'name' => 'id',
            'value' => '',
            'attribs' => [
                'size' => 60,
            ],
        ]); ?></label>

        <?= $this->routeSubmit(
            'Create',
            PostPageAdd::CLASS
        ); ?>
    </p>

    <div id="submit-failure"></div>
</form>

<h2>Existing Pages</h2>
<table>
    <tr>
        <th>At</th>
        <th>Title</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($this->pages as $page): ?>
    <tr valign="top">
        <td><?= $this->escape()->html($page->href); ?></td>
        <td><?= $this->escape()->html($page->title); ?></td>
        <td><?= $this->anchorLocal($page->href, 'View', ['target' => '_blank']); ?></td>
        <td><?= $this->anchor(
            $this->route(GetPage::CLASS, $page->id),
            'Edit'
        ); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
