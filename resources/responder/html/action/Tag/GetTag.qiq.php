{{ use
    Argo\Sapi\Http\Action\Tag\PostTag,
    Argo\Sapi\Http\Action\Tag\DeleteTag
}}
{{ $header = 'Tag' }}

<div class="card card-outline">
    <div class="card-header">
        <h4>{{h $tag->relId }}</h4>
    </div>
    <div class="card-body">
        {{= render ('item', [
            'item' => $tag,
            'submitActionPost' => PostTag::CLASS,
            'submitActionDelete' => DeleteTag::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4>{{= $tag->title }}</h4>
        {{= bodyPreview ($tag) }}
    </div>
</div>
