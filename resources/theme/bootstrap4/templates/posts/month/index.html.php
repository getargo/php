                <article class="MonthArticle">
                    <header class="ArticleHeader">
                        <h1>{{= anchor
                            $this->month->href,
                            $this->month->title
                        }}</h1>
                    </header>
                    <section class="ArticleBody">
                        <dl>{{ foreach $this->month->posts as $post }}

                            <dt><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></dt>
                            <dd>{{= anchor $post->href, $post->title }}</dd>

                        {{ endforeach }}</dl>
                    </section>
                </article>

                {{= render 'prevnext' }}
