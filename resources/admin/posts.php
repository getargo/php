<?php
use Argo\Http\Action\Post\GetPost;
use Argo\Http\Action\Posts\GetPosts;

$this->header = 'Posts';
?>
<div class="card card-outline">
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

        <p>
            <span><?= ($this->pageNum == 1)
                ? 'First'
                : $this->anchor($this->route(GetPosts::CLASS, $this->pageNum - 1), 'Previous');
            ?></span>

            <span>(Page <?= $this->escape()->html($this->pageNum); ?>
            of <?= $this->escape()->html($this->pageCount); ?>)</span>

            <span><?= ($this->pageNum == $this->pageCount)
                ? 'Last'
                : $this->anchor($this->route(GetPosts::CLASS, $this->pageNum + 1), 'Next');
            ?></span>
        </p>
    </div>
</div>
