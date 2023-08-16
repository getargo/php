{{ use
    Argo\Sapi\Http\Action\Tag\GetTag,
    Argo\Sapi\Http\Action\Tag\Add\PostTagAdd
}}
{{ $header = 'Tags' }}

<div class="card card-outline">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{~ foreach ($tags as $tag): }}
                <tr>
                    <td>{{h $tag->relId }}</td>
                    <td>{{h $tag->title }}</td>
                    <td>
                        {{= anchorLocal (
                            $tag->href,
                            'View',
                            target: '_blank'
                        ) }}&nbsp;{{= anchorAction (
                            'Edit',
                            GetTag::CLASS,
                            $tag->relId
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
                <label>Create New Tag Named: {{= textField (
                    name: 'relId',
                    value: '',
                    size: 60,
                ) }}</label>

                {{= submitAction (
                    'Create',
                    PostTagAdd::CLASS
                ) }}
            </p>
            <div id="submit-failure"></div>
        </form>
    </div>
</div>
