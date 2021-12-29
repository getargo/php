{{ use
    Argo\Sapi\Http\Action\Draft\DeleteDraft,
    Argo\Sapi\Http\Action\Draft\PostDraft
}}

{{ $this->header = 'Draft' }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->draft,
            'submitActionPost' => PostDraft::CLASS,
            'submitActionDelete' => DeleteDraft::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h2>{{= $this->draft->title ?? '---' }}</h2>
        {{=  bodyPreview ($this->draft) }}
    </div>
</div>
