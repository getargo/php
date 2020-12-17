<?= $this->tag->toJson([
    'html' => $this->body($this->tag),
    'posts' => $this->tag->posts
]);
