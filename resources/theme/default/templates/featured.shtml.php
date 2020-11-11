<?php foreach ($this->config->featured as $title => $href): ?>

<li><?= $this->anchor($href, $title) ?></li>

<?php endforeach; ?>
