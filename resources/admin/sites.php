<?php
use Argo\Http\Action\Site\GetSite;
use Argo\Http\Action\Site\PostSite;

$this->header = 'Sites';
?>
<div class="card card-outline">
    <div class="card-body">


        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Folder</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->sites as $name => $folder): ?>
                <tr>
                    <td><?= $this->escape()->html($name); ?></td>
                    <td><?= $this->escape()->html($folder); ?></td>
                    <td><?php
                        if ($folder === $this->docroot) {
                            echo "(current site)";
                        } else {
                            echo $this->anchor(
                                $this->route(GetSite::CLASS, $name),
                                'Swap'
                            );
                        }
                    ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card card-outline">
    <div class="card-header">
        <h4>Create New Site</h4>
    </div>
    <div class="card-body">

        <form onsubmit="return false;">
            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="name">Folder Name</label>
                </div>
                <div class="col">
                    <?= $this->input([
                        'type' => 'text',
                        'name' => 'name',
                        'value' => '',
                        'attribs' => [
                            'class' => 'form-control',
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="title">Blog Title</label>
                </div>
                <div class="col">
                    <?= $this->input([
                        'type' => 'text',
                        'name' => 'title',
                        'value' => '',
                        'attribs' => [
                            'class' => 'form-control',
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="tagline">Blog Tagline</label>
                </div>
                <div class="col">
                    <?= $this->input([
                        'type' => 'text',
                        'name' => 'tagline',
                        'value' => '',
                        'attribs' => [
                            'class' => 'form-control',
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="author">Author Name</label>
                </div>
                <div class="col">
                    <?= $this->input([
                        'type' => 'text',
                        'name' => 'author',
                        'value' => $this->author,
                        'attribs' => [
                            'class' => 'form-control',
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="url">Site URL</label>
                </div>
                <div class="col">
                    <?= $this->input([
                        'type' => 'text',
                        'name' => 'url',
                        'value' => '',
                        'attribs' => [
                            'class' => 'form-control',
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                </div>
                <div class="col">
                    <?= $this->routeSubmit(
                        'Create',
                        PostSite::CLASS
                    ); ?>
                    &nbsp;
                    <span id="submit-failure"></span>
                </div>
            </div>


        </form>
    </div>
</div>
