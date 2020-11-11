                <?php foreach ($this->postIndex->posts as $post): ?>

                <article class="row">
                    <aside class="col-3 text-right pt-1">
                        <time datetime="<?= $this->dateTime()->attr($post->created); ?>">
                            <?= $this->dateTime()->html($post->created, 'l') ?><br />
                            <span class="display-4"><?= $this->dateTime()->html($post->created, 'd') ?></span><br />
                            <?= $this->dateTime()->html($post->created, 'M Y') ?><br />
                        </time>

                        <address rel="author"><?= $this->escape()->html($post->author) ?></address>

                        <ul class="list-unstyled"><?php foreach ($post->tags as $k => $tag): ?>
                            <li class="small"><?= $this->anchor($tag->href, $tag->title); ?></li>
                        <?php endforeach; ?></ul>
                    </aside>
                    <section class="col-9">
                        <header>
                            <h2><?= $this->anchor(
                                $post->href,
                                $post->title
                            ) ?></h2>
                        </header>
                        <?= $this->bodyLess($post); ?>
                    </section>
                </article>

                <hr />

                <?php endforeach; ?>

                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-9">
                        <?= $this->render('prevnext') ?>
                    </div>
                </div>
