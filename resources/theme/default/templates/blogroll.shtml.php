<?php foreach ($this->config->blogroll as $title => $href): ?>

<li><?= $this->anchor($href, $title) ?></li>

<?php endforeach; ?>
