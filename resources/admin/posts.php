{{ use
    Argo\Http\Action\Post\GetPost,
    Argo\Http\Action\Posts\GetPosts
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
                {{ foreach ($this->posts as $post): }}
                <tr>
                    <td><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></td>
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
                            $this->route(GetPost::CLASS, $post->relId),
                            'Edit'
                        ) }}
                    </td>
                </tr>
                {{ endforeach }}
            </tbody>
        </table>

        <p>
            <span>{{=
                $this->pageNum == 1
                    ? 'First'
                    : $this->anchor(
                        $this->route(
                            GetPosts::CLASS,
                            $this->pageNum - 1
                        ),
                        'Previous'
                    );
            }}</span>

            <span>(Page {{h ($this->pageNum }} of {{h $this->pageCount }})</span>

            <span>{{=
                $this->pageNum == $this->pageCount
                    ? 'Last'
                    : $this->anchor(
                        $this->route(
                            GetPosts::CLASS,
                            $this->pageNum + 1
                        ),
                        'Next'
                    );
            }}</span>
        </p>
    </div>
</div>
