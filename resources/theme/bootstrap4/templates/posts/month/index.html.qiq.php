                <article class="MonthArticle">
                    <header class="ArticleHeader">
                        <h1>{{= anchor (
                            $month->href,
                            $month->title
                        ) }}</h1>
                    </header>
                    <section class="ArticleBody">
                        <dl>{{ foreach ($month->posts as $post): }}

                            <dt>{{= dateTime ($post->created, 'Y-m-d') }}</dt>
                            <dd>{{= anchor ($post->href, $post->title) }}</dd>

                        {{ endforeach }}</dl>
                    </section>
                </article>

                {{= render ('prevnext') }}
