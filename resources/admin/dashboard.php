<?php
use Argo\Http\Action\Build\PostBuild;
use Argo\Http\Action\Draft\Add\PostDraftAdd;
use Argo\Http\Action\Draft\GetDraft;
use Argo\Http\Action\Post\GetPost;
use Argo\Http\Action\Posts\GetPosts;
use Argo\Http\Action\Sync\PostSync;
?>
<h1>Dashboard</h1>

<table>
    <tr>
        <td><?php
            echo $this->form([
                'method' => 'post',
                'action' => $this->route(PostBuild::CLASS),
            ]);

            echo $this->input([
                'type' => 'submit',
                'name' => 'build',
                'value' => 'Build Local',
            ]);

            echo "</form>";
        ?></td>

        <td><?= $this->anchorLocal('/', 'View Local', ['target' => '_blank']); ?></td>

        <td><code><?= $this->anchor(
            "javascript:openFolder('{$this->local}');",
            $this->local
        ); ?> </code></td>
    </tr>

    <?php if ($this->remote !== ''): ?>
    <tr>
        <td><?php
            echo $this->form([
                'method' => 'post',
                'action' => $this->route(PostSync::CLASS),
            ]);

            echo $this->input([
                'type' => 'submit',
                'name' => 'sync',
                'value' => 'Sync Remote',
            ]);

            echo "</form>";
        ?></td>

        <td><?php
            echo $this->anchor($this->remote, 'View Remote', ['target' => '_blank']);
        ?></td>

        <td><code><?= $this->escape()->html($this->remote); ?></code></td>
    </tr>
    <?php endif; ?>

</table>

<h2>Drafts</h2>

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
    <div id="submit-failure"></div>

    <p>
        <label>Start New Draft Titled: <?= $this->input([
            'type' => 'text',
            'name' => 'title',
            'value' => '',
            'attribs' => [
                'size' => 60,
            ],
        ]); ?></label>

        <?= $this->routeSubmit('Create', PostDraftAdd::CLASS) ?>
    </p>
</form>

<h2>Latest Posts</h2>

<table>
    <?php foreach ($this->posts as $post): ?>
    <tr valign="top">
        <td><?= $this->dateTime()->html($post->created, 'Y-m-d'); ?></td>
        <td><?php
            echo $this->escape()->html($post->title);
            echo "<br />";
            echo "<em>" . $this->escape()->html(implode(', ', $post->tags)) . "</em>";
        ?></td>
        <td><?= $this->anchorLocal($post->href, 'View', ['target' => '_blank']); ?></td>
        <td><?= $this->anchor(
            $this->route(GetPost::CLASS, $post->relId),
            'Edit'
        ); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><?= $this->anchor($this->route(GetPosts::CLASS), 'All Posts'); ?></p>
