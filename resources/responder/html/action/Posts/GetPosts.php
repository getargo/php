{{ use
    Argo\Sapi\Http\Action\Post\GetPost,
    Argo\Sapi\Http\Action\Posts\GetPosts
}}
{{ $this->header = 'Posts' }}

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
                {{~ foreach ($this->posts as $post): }}
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
                            [
                                'target' => '_blank'
                            ]
                        ) }}&nbsp;{{= anchor (
                            $this->action(GetPost::CLASS, $post->relId),
                            'Edit'
                        ) }}
                    </td>
                </tr>
                {{~ endforeach }}

            </tbody>
        </table>

        <p>
            <span>{{=
                $this->pageNum == 1
                    ? 'First'
                    : $this->anchor(
                        $this->action(
                            GetPosts::CLASS,
                            $this->pageNum - 1
                        ),
                        'Previous'
                    );
            }}</span>
            <span>(Page {{h $this->pageNum }} of {{h $this->pageCount }})</span>
            <span>{{=
                $this->pageNum == $this->pageCount
                    ? 'Last'
                    : $this->anchor(
                        $this->action(
                            GetPosts::CLASS,
                            $this->pageNum + 1
                        ),
                        'Next'
                    );
            }}</span>
        </p>
    </div>
</div>
