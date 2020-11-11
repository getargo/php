<?php foreach ($this->months as $month): ?>

<li><?=
    $this->anchor($month->href, $month->title)
    . ' (' . count($month->posts) . ')'
; ?></li>

<?php endforeach; ?>
