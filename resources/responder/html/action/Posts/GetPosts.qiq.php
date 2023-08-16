{{ use
    Argo\Sapi\Http\Action\Post\GetPost,
    Argo\Sapi\Http\Action\Posts\GetPosts
}}
{{ $header = 'Posts' }}

<div class="card card-outline">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title / Tags</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{~ foreach ($posts as $post): }}
                <tr>
                    <td>{{= dateTime ($post->created, 'Y-m-d') }}</td>
                    <td>
                        {{h $post->title}}<br />
                        <em>{{h implode(', ', $post->tags) }}</em>
                    </td>
                    <td>
                        {{= anchorLocal (
                            $post->href,
                            'View',
                            target: '_blank'
                        ) }}&nbsp;{{= anchorAction (
                            'Edit',
                            GetPost::CLASS,
                            $post->relId
                        ) }}
                    </td>
                </tr>
                {{~ endforeach }}

            </tbody>
        </table>

        <p>
            <span>{{=
                $pageNum == 1
                    ? 'First'
                    : anchorAction(
                        'Previous',
                        GetPosts::CLASS,
                        $pageNum - 1
                    );
            }}</span>
            <span>(Page {{h $pageNum }} of {{h $pageCount }})</span>
            <span>{{=
                $pageNum == $pageCount
                    ? 'Last'
                    : anchorAction(
                        'Next',
                        GetPosts::CLASS,
                        $pageNum + 1
                    );
            }}</span>
        </p>
    </div>
</div>
