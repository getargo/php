{{ use
    Argo\Sapi\Http\Action\Build\GetBuild,
    Argo\Sapi\Http\Action\Draft\Add\PostDraftAdd,
    Argo\Sapi\Http\Action\Draft\GetDraft,
    Argo\Sapi\Http\Action\Post\GetPost,
    Argo\Sapi\Http\Action\Posts\GetPosts,
    Argo\Sapi\Http\Action\Sync\GetSync
}}
{{ $this->header = 'Dashboard' }}

<div class="card">
    <div class="card-body">
        <div class="row mb-1">
            <div class="col col-2">
                {{= form ([
                    'method' => 'get',
                    'action' => $this->action(GetBuild::CLASS),
                ]) }}
                    {{= submitButton ([
                        'name' => 'build',
                        'value' => 'Build Local',
                    ]) }}
                </form>
            </div>

            <div class="col">
                {{= anchorLocal (
                    '/',
                    'View Local',
                    [
                        'target' => '_blank'
                    ]
                ) }}
            </div>
        </div>

        {{ if ($this->remote !== ''): }}

        <div class="row mb-1">
            <div class="col col-2">
                {{= form ([
                    'method' => 'get',
                    'action' => $this->action(GetSync::CLASS),
                ]) }}
                    {{= submitButton ([
                        'name' => 'sync',
                        'value' => 'Sync Remote',
                    ]) }}
                </form>
            </div>

            <div class="col">
                {{= anchor (
                    $this->remote,
                    'View Remote',
                    [
                        'target' => '_blank'
                    ]
                ) }}
            </div>
        </div>

        {{ endif }}

    </div>
</div>

<div class="card card-outline">
    <div class="card-header">
        <h4>Drafts</h4>
    </div>
    <div class="card-body">
        <ol>
            {{~ foreach ($this->drafts as $id => $draft): }}
            <li>{{= anchor (
                    $this->action(GetDraft::CLASS, $draft->relId),
                    $draft->title ?? $draft->relId
                ) }}{{h
                    " ({$draft->id})"
                }}</li>
            {{~ endforeach }}
        </ol>

        <form onsubmit="return false;">
            <p>
                <label>Create New Draft Titled: {{= textField ([
                    'name' => 'title',
                    'value' => '',
                    'size' => 60,
                ]) }}</label>
                {{= submitAction ('Create', PostDraftAdd::CLASS) }}
            </p>
            <div id="submit-failure"></div>
        </form>
    </div>
</div>

<div class="card card-outline">
    <div class="card-header">
        <h4>Latest Posts</h4>
    </div>
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
                        {{h $post->title }}
                        <br />
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

        <p>{{= anchor ($this->action(GetPosts::CLASS, 2), 'More Posts') }}</p>
    </div>
</div>
