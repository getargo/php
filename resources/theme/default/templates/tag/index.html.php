                <article class="Article">
                    <div class="Article__Main">
                        <header class="Article__Header">
                            <h1 class="Article__Heading"><?= $this->anchor(
                                $this->tag->href,
                                $this->tag->title,
                                [
                                    'class' => 'Article__HeadingLink'
                                ]
                            ) ?></h1>
                        </header>
                        <section class="Article__Body">
                            <?= $this->body($this->tag) ?>

                            <dl><?php foreach ($this->tag->posts as $post): ?>

                                <dt><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></dt>
                                <dd><?= $this->anchor($post->href, $post->title) ?></dd>

                            <?php endforeach; ?></dl>
                        </section>
                    </div>

                    <?= $this->render('prevnext') ?>

                </article>
