{{ use
    Argo\Sapi\Http\Action\Post\DeletePost,
    Argo\Sapi\Http\Action\Post\PostPost
}}
{{ $this->header = 'Post' }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->post,
            'submitActionPost' => PostPost::CLASS,
            'submitActionDelete' => DeletePost::CLASS,
        ]) }}
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4>{{= $this->post->title }}</h4>
        {{= bodyPreview ($this->post) }}
    </div>
</div>
