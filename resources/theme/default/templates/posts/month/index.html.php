                <article>
                    <header>
                        <h1><?= $this->anchor(
                            $this->month->href,
                            $this->month->title
                        ) ?></h1>
                    </header>
                    <section>
                        <dl><?php foreach ($this->month->posts as $post): ?>

                            <dt><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></dt>
                            <dd><?= $this->anchor($post->href, $post->title) ?></dd>

                        <?php endforeach; ?></dl>
                    </section>
                </article>

                <?= $this->render('prevnext') ?>
