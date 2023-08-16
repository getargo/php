{{ use
    Argo\Sapi\Http\Action\Draft\DeleteDraft,
    Argo\Sapi\Http\Action\Draft\PostDraft
}}

{{ $header = 'Draft' }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $draft,
            'submitActionPost' => PostDraft::CLASS,
            'submitActionDelete' => DeleteDraft::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h2>{{= $draft->title ?? '---' }}</h2>
        {{=  bodyPreview ($draft) }}
    </div>
</div>
