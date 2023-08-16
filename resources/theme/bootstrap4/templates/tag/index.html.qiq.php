                <article class="TagArticle">
                    <header class="ArticleHeader">
                        <h1>{{= anchor (
                            $tag->href,
                            $tag->title
                        ) }}</h1>
                    </header>
                    <section class="ArticleBody">
                        {{= body ($tag) }}

                        <dl>{{ foreach ($tag->posts as $post): }}

                            <dt>{{= dateTime ($post->created, 'Y-m-d') }}</dt>
                            <dd>{{= anchor ($post->href, $post->title) }}</dd>

                        {{ endforeach }}</dl>
                    </section>
                </article>

                {{= render ('prevnext') }}
