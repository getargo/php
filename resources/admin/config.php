<?php
use Argo\Http\Action\Config\PostConfig;
?>
<h1>Config</h1>
<h2><?= $this->escape()->html(ucfirst($this->name)); ?></h2>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <p><?= $this->input([
        'type' => 'textarea',
        'name' => 'text',
        'value' => $this->text,
    ]); ?></p>

    <p><?= $this->routeSubmit('Save', PostConfig::CLASS, $this->name); ?></p>
</form>
