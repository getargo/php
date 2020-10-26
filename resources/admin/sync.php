<?php
$this->header = 'Syncing To Remote Site';
?>
<div class="card card-outline">
    <div class="card-body">
        <pre id="process-stream"></pre>
        <script>process('sync');</script>
    </div>
</div>
