{{ setLayout(null) }}
{{= $month->toJson([
    'posts' => $month->posts
]) }}
