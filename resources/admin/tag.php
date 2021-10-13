{{ use
    Argo\Http\Action\Tag\PostTag,
    Argo\Http\Action\Tag\DeleteTag
}}
{{ $this->header = 'Tag' }}

<div class="card card-outline">
    <div class="card-header">
        <h4>{{h $this->tag->relId) }}</h4>
    </div>
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->tag,
            'routeSubmitPost' => PostTag::CLASS,
            'routeSubmitDelete' => DeleteTag::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4>{{= $this->tag->title }}</h4>
        {{= bodyPreview ($this->tag) }}
    </div>
</div>
