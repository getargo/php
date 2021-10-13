                <article class="TagArticle">
                    <header class="ArticleHeader">
                        <h1>{{= anchor
                            $this->tag->href,
                            $this->tag->title
                        }}</h1>
                    </header>
                    <section class="ArticleBody">
                        {{= body $this->tag }}

                        <dl>{{ foreach $this->tag->posts as $post }}

                            <dt><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></dt>
                            <dd>{{= anchor $post->href, $post->title }}</dd>

                        {{ endforeach }}</dl>
                    </section>
                </article>

                {{= render 'prevnext' }}
