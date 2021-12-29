{{ use
    Argo\Sapi\Http\Action\Site\GetSite,
    Argo\Sapi\Http\Action\Site\PostSite
}}
{{ $this->header = 'Sites' }}

<div class="card card-outline">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Folder</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{~ foreach ($this->sites as $name => $folder): }}
                <tr>
                    <td>{{h $name }}</td>
                    <td>{{h $folder }}</td>
                    <td>{{ if ($folder === $this->docroot): }}
                        (current site)
                    {{ else: }}
                        {{= anchor (
                            $this->action(GetSite::CLASS, $name),
                            'Swap'
                        ) }}
                    {{ endif }}
                    </td>
                </tr>
                {{~ endforeach }}
            </tbody>
        </table>
    </div>
</div>

<div class="card card-outline">
    <div class="card-header">
        <h4>Create New Site</h4>
    </div>
    <div class="card-body">

        <form onsubmit="return false;">
            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="name">Folder Name</label>
                </div>
                <div class="col">
                    {{= textField ([
                        'name' => 'name',
                        'value' => '',
                        'class' => 'form-control',
                    ]) }}
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="title">Blog Title</label>
                </div>
                <div class="col">
                    {{= textField ([
                        'type' => 'text',
                        'name' => 'title',
                        'value' => '',
                        'class' => 'form-control',
                    ]) }}
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="tagline">Blog Tagline</label>
                </div>
                <div class="col">
                    {{= textField ([
                        'name' => 'tagline',
                        'value' => '',
                        'class' => 'form-control',
                    ]) }}
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="author">Author Name</label>
                </div>
                <div class="col">
                    {{= textField ([
                        'name' => 'author',
                        'value' => $this->author,
                        'class' => 'form-control',
                    ]) }}
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                    <label for="url">Site URL</label>
                </div>
                <div class="col">
                    {{= textField ([
                        'name' => 'url',
                        'value' => '',
                        'class' => 'form-control',
                    ]) }}
                </div>
            </div>

            <div class="row mb-1 align-items-start">
                <div class="col col-2 text-right">
                </div>
                <div class="col">
                    {{= submitAction (
                        'Create',
                        PostSite::CLASS
                    ) }}
                    &nbsp;
                    <span id="submit-failure"></span>
                </div>
            </div>
        </form>
    </div>
</div>
