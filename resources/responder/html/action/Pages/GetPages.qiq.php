{{ use
    Argo\Sapi\Http\Action\Page\GetPage,
    Argo\Sapi\Http\Action\Page\Add\PostPageAdd,
    Argo\Sapi\Http\Action\Pages\GetPages
}}
{{ $header = 'Pages' }}

<div class="card card-outline">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>At</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{~ foreach ($pages as $page): }}
                <tr>
                    <td>{{h $page->href }}</td>
                    <td>{{h $page->title }}</td>
                    <td>
                        {{= anchorLocal (
                            $page->href,
                            'View',
                            target: '_blank'
                        ) }}&nbsp;{{= anchorAction (
                            'Edit',
                            GetPage::CLASS,
                            $page->id
                        ) }}
                    </td>
                </tr>
                {{~ endforeach }}
            </tbody>
        </table>
    </div>
</div>

<div class="card card-outline">
    <div class="card-body">
        <form onsubmit="return false;">
            <p>
                <label>Create New Page At: {{= textField(
                    name: 'id',
                    value: '',
                    size: 60,
                ) }}</label>

                {{= submitAction (
                    'Create',
                    PostPageAdd::CLASS
                ) }}
            </p>

            <div id="submit-failure"></div>
        </form>

    </div>
</div>
