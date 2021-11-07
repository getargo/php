<article class="PostArticle row">
    <aside class="ArticleMeta col-3 text-right pt-1">
        {{= penders ($this, 'post-meta-prepend') }}

        <time datetime="{{= dateTime ($this->post->created) }}">
            {{= dateTime ($this->post->created, 'l') }}<br />
            <span class="display-4">{{= dateTime ($this->post->created, 'd') }}</span><br />
            {{= dateTime ($this->post->created, 'M Y') }}<br />
        </time>

        <address rel="author">{{h $this->post->author }}</address>

        <ul class="list-unstyled">{{ foreach ($this->post->tags as $tag): }}
            <li class="small">{{= anchor ($tag->href, $tag->title) }}</li>
        {{ endforeach }}</ul>

        {{= penders ($this, 'post-meta-append') }}
    </aside>
    <div class="col-9">
        <header class="ArticleHeader">
            {{= penders ($this, 'post-header-prepend') }}

            <h2>{{= anchor (
                $this->post->href,
                $this->post->title
            ) }}</h2>

            {{= penders ($this, 'post-header-append') }}
        </header>
        <section class="ArticleBody">
            {{= penders ($this, 'post-body-prepend') }}
            {{= body ($this->post) }}
            {{= penders ($this, 'post-body-append') }}
        </section>
    </div>
</article>

<div class="row">
    <div class="col-3"></div>
    <div class="col-9">
        {{= render ('prevnext') }}
    </div>
</div>
