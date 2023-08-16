{{ use
    Argo\Sapi\Http\Action\Post\DeletePost,
    Argo\Sapi\Http\Action\Post\PostPost
}}
{{ $header = 'Post' }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $post,
            'submitActionPost' => PostPost::CLASS,
            'submitActionDelete' => DeletePost::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4>{{= $post->title }}</h4>
        {{= bodyPreview ($post) }}
    </div>
</div>
