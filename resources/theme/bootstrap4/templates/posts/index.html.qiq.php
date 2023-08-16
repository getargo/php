                {{ foreach ($postIndex->posts as $post): }}

                <article class="PostArticle row">
                    <aside class="ArticleMeta col-3 text-right pt-1">
                        <time datetime="{{ dateTime ($post->created) }}">
                            {{= dateTime ($post->created, 'l') }}<br />
                            <span class="display-4">{{= dateTime ($post->created, 'd') }}</span><br />
                            {{= dateTime ($post->created, 'M Y') }}<br />
                        </time>

                        <address rel="author">{{h $post->author }}</address>

                        <ul class="list-unstyled">{{foreach ($post->tags as $tag): }}
                            <li class="small">{{= anchor ($tag->href, $tag->title) }}</li>
                        {{ endforeach }}</ul>
                    </aside>
                    <div class="col-9">
                        <header class="ArticleHeader">
                            <h2>{{= anchor (
                                $post->href,
                                $post->title
                            ) }}</h2>
                        </header>
                        <section class="ArticleBody">
                            {{= bodyLess ($post) }}
                        </section>
                    </div>
                </article>

                <hr />

                {{ endforeach }}

                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-9">
                        {{= render ('prevnext') }}
                    </div>
                </div>
