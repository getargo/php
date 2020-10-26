<?php
use Argo\Http\Action\Build\GetBuild;
use Argo\Http\Action\Draft\Add\PostDraftAdd;
use Argo\Http\Action\Draft\GetDraft;
use Argo\Http\Action\Post\GetPost;
use Argo\Http\Action\Posts\GetPosts;
use Argo\Http\Action\Sync\GetSync;

$this->header = 'Dashboard';
?>
<div class="card">
    <div class="card-body">
        <div class="row mb-1">
            <div class="col col-2"><?php
                echo $this->form([
                    'method' => 'get',
                    'action' => $this->route(GetBuild::CLASS),
                ]);

                echo $this->input([
                    'type' => 'submit',
                    'name' => 'build',
                    'value' => 'Build Local',
                ]);

                echo "</form>";
            ?></div>

            <div class="col"><?=
                $this->anchorLocal('/', 'View Local', ['target' => '_blank']);
            ?></div>

            <div class="col"><code><?= $this->anchor(
                "javascript:openFolder('{$this->local}');",
                $this->local
            ); ?> </code></div>
        </div>

        <?php if ($this->remote !== ''): ?>

        <div class="row mb-1">
            <div class="col col-2"><?php
                echo $this->form([
                    'method' => 'get',
                    'action' => $this->route(GetSync::CLASS),
                ]);

                echo $this->input([
                    'type' => 'submit',
                    'name' => 'sync',
                    'value' => 'Sync Remote',
                ]);

                echo "</form>";
            ?></div>

            <div class="col"><?=
                $this->anchor($this->remote, 'View Remote', ['target' => '_blank']);
            ?></div>

            <div class="col"><code><?=
                $this->escape()->html($this->remote);
            ?></code></div>

        </div>

        <?php endif; ?>

    </div>
</div>

<div class="card card-outline">
    <div class="card-header">
        <h4>Drafts</h4>
    </div>
    <div class="card-body">
        <?php
            foreach ($this->drafts as $id => $draft) {
                $this->ol()->rawItem($this->anchor(
                    $this->route(GetDraft::CLASS, $draft->relId),
                    $this->escape()->html($draft->title ?? $draft->relId)
                )  . " ({$draft->id})");
            }

            echo $this->ol();
        ?>

        <form onsubmit="return false;">
            <p>
                <label>Create New Draft Titled: <?= $this->input([
                    'type' => 'text',
                    'name' => 'title',
                    'value' => '',
                    'attribs' => [
                        'size' => 60,
                    ],
                ]); ?></label>

                <?= $this->routeSubmit('Create', PostDraftAdd::CLASS) ?>
            </p>
            <div id="submit-failure"></div>
        </form>
    </div>
</div>

<div class="card card-outline">
    <div class="card-header">
        <h4>Latest Posts</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title / Tags</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->posts as $post): ?>
                <tr>
                    <td><?= $this->dateTime()->html($post->created, 'Y-m-d'); ?></td>
                    <td><?php
                        echo $this->escape()->html($post->title);
                        echo "<br />";
                        echo "<em>" . $this->escape()->html(implode(', ', $post->tags)) . "</em>";
                    ?></td>
                    <td>
                        <?= $this->anchorLocal($post->href, 'View', ['target' => '_blank']); ?>
                        &nbsp;
                        <?= $this->anchor(
                            $this->route(GetPost::CLASS, $post->relId),
                            'Edit'
                        ); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><?= $this->anchor($this->route(GetPosts::CLASS, 2), 'More Posts'); ?></p>
    </div>
</div>
