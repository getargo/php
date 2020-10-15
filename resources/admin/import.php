<?php
use Argo\Http\Action\Import\PostImport;
?>
<h1>Import WordPress Content</h1>

<p><strong>This feature is EXPERIMENTAL and may be subject to change.</strong></p>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <p><?= $this->input([
        'type' => 'file',
        'name' => 'wpxml',
    ]); ?></p>

    <p><?= $this->routeSubmit(
        'Import WordPress',
        PostImport::CLASS
    ); ?></p>
</form>
