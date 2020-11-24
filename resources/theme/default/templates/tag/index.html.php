                <article>
                    <header>
                        <h1><?= $this->anchor(
                            $this->tag->href,
                            $this->tag->title
                        ) ?></h1>
                    </header>
                    <section>
                        <?= $this->body($this->tag) ?>

                        <dl><?php foreach ($this->tag->posts as $post): ?>

                            <dt><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></dt>
                            <dd><?= $this->anchor($post->href, $post->title) ?></dd>

                        <?php endforeach; ?></dl>
                    </section>
                </article>

                <?= $this->render('prevnext') ?>
