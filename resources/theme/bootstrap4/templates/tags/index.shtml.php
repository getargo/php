<?php foreach ($this->tags as $tag): ?>

<li><?=
    $this->anchor($tag->href, $tag->title)
    . ' (' . count($tag->posts) . ')'
; ?></li>

<?php endforeach; ?>
