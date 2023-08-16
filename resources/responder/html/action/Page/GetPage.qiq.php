{{ use
    Argo\Sapi\Http\Action\Page\DeletePage,
    Argo\Sapi\Http\Action\Page\PostPage
}}
{{ $header = 'Page'; }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $page,
            'submitActionPost' => PostPage::CLASS,
            'submitActionDelete' => DeletePage::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h3>{{= $page->title }}</h3>
        {{= bodyPreview ($page) }}
    </div>
</div>
