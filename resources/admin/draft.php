{{ use
    Argo\Http\Action\Draft\DeleteDraft,
    Argo\Http\Action\Draft\PostDraft
}}
{{ $this->header = 'Draft' }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->draft,
            'routeSubmitPost' => PostDraft::CLASS,
            'routeSubmitDelete' => DeleteDraft::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h2>{{= $this->draft->title ?? '---' }}</h2>
        {{=  bodyPreview ($this->draft) }}
    </div>
</div>
