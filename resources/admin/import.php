<?php
use Argo\Http\Action\Import\PostImport;

$this->header = 'Import WordPress Content';
?>
<div class="card card-outline">
    <div class="card-body">
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

        <pre id="submit-stream"></pre>
    </div>
</div>