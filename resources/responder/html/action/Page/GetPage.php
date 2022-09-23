{{ use
    Argo\Sapi\Http\Action\Page\DeletePage,
    Argo\Sapi\Http\Action\Page\PostPage
}}
{{ $this->header = 'Page'; }}

<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->page,
            'submitActionPost' => PostPage::CLASS,
            'submitActionDelete' => DeletePage::CLASS,
        ]) }}
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <h3>{{= $this->page->title }}</h3>
        {{= bodyPreview ($this->page) }}
    </div>
</div>
