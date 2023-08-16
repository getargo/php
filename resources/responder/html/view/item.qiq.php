{{ use Argo\Domain\Model\Content\Tag\Tag }}
{{ use Argo\Domain\Model\Content\Draft\Draft }}
{{ use Argo\Sapi\Http\Action\Draft\Publish\PostDraftPublish }}

<form onsubmit="return false;">

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label>URL</label>
        </div>
        <div class="col">{{h $item->href }}</div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="title">Title</label>
        </div>
        <div class="col">
            {{= textField (
                name: 'title',
                value: $item->title,
                class: 'form-control',
            ) }}
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="body">Body</label>
        </div>
        <div class="col">
            {{= textarea (
                name: 'body',
                value: $body,
                class: 'form-control h-100',
                style: 'font-size: 85%;',
                rows: '12',
            ) }}
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="markup">Markup</label>
        </div>
        <div class="col">
            {{= select (
                name: 'markup',
                class: 'form-control',
                value: $item->markup,
                options: [
                    'html' => 'HTML',
                    'markdown' => 'Markdown',
                    'wordpress' => 'WordPress',
                ],
            ) }}
        </div>
    </div>

    {{ if (! $item instanceof Tag): }}

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="tags">Tags</label>
        </div>
        <div class="col">
            {{= textField (
                name: 'tags',
                value: implode(', ', $item->tags),
                class: 'form-control',
            ) }}
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
            <label for="author">Author</label>
        </div>
        <div class="col">
            {{= textField (
                name: 'author',
                value: $item->author,
                class: 'form-control',
            ) }}
        </div>
    </div>

    {{ endif }}

    <div class="row mb-1 align-items-start">
        <div class="col col-1 text-right">
        </div>
        <div id="submit-failure">
        </div>
    </div>

    <div class="row mb-1 align-items-start">
        <div class="col col-1">
        </div>
        <div class="col">
            {{= submitAction (
                'Save',
                $submitActionPost,
                $item->relId
            ) }}

            {{ if ($item instanceof Draft): }}

            {{= submitAction (
                'Publish',
                PostDraftPublish::CLASS,
                $draft->relId
            ) }}

            {{ endif }}

            {{= anchorOpenFolder ($item->id) }}

            <span style="float: right;">{{= submitAction (
                'Trash',
                $submitActionDelete,
                $item->relId
            ) }}</span>
        </div>
    </div>
</form>
