{{ use
    Argo\Sapi\Http\Action\Tag\PostTag,
    Argo\Sapi\Http\Action\Tag\DeleteTag
}}
{{ $this->header = 'Tag' }}

<div class="card card-outline">
    <div class="card-header">
        <h4>{{h $this->tag->relId }}</h4>
    </div>
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->tag,
            'submitActionPost' => PostTag::CLASS,
            'submitActionDelete' => DeleteTag::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4>{{= $this->tag->title }}</h4>
        {{= bodyPreview ($this->tag) }}
    </div>
</div>
