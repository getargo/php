<?php
use Argo\Http\Action\Tag\GetTag;
use Argo\Http\Action\Tag\Add\PostTagAdd;

$this->header = 'Tags';
?>
<div class="card card-outline">
    <div class="card-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->tags as $tag): ?>
                <tr>
                    <td><?= $this->escape()->html($tag->relId); ?></td>
                    <td><?= $this->escape()->html($tag->title); ?></td>
                    <td>
                        <?= $this->anchorLocal($tag->href, 'View', ['target' => '_blank']); ?>

                        &nbsp;

                        <?= $this->anchor(
                            $this->route(GetTag::CLASS, $tag->relId),
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
                <label>Create New Tag Named: <?= $this->input([
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
    </div>
</div>
