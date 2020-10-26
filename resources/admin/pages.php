<?php
use Argo\Http\Action\Page\GetPage;
use Argo\Http\Action\Page\Add\PostPageAdd;
use Argo\Http\Action\Pages\GetPages;

$this->header = 'Pages';
?>
<div class="card card-outline">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>At</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->pages as $page): ?>
                <tr>
                    <td><?= $this->escape()->html($page->href); ?></td>
                    <td><?= $this->escape()->html($page->title); ?></td>
                    <td>
                        <?= $this->anchorLocal($page->href, 'View', ['target' => '_blank']); ?>
                        &nbsp;
                        <?= $this->anchor(
                            $this->route(GetPage::CLASS, $page->id),
                            'Edit'
                        ); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
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

    </div>
</div>
