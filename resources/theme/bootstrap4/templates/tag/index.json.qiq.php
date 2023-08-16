{{ setLayout(null) }}
{{= $tag->toJson([
    'html' => body($tag),
    'posts' => $tag->posts
]) }}
