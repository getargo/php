{{ setLayout(null) }}
{{= $post->toJson([
    'html' => body($post)
]) }}
