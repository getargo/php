                <article class="Article">
                    <div class="Article__Main">
                        <header class="Article__Header">
                            <h1 class="Article__Heading"><?= $this->anchor(
                                $this->month->href,
                                $this->month->title,
                                [
                                    'class' => 'Article__HeadingLink'
                                ]
                            ) ?></h1>
                        </header>
                        <section class="Article__Body">
                            <dl><?php foreach ($this->month->posts as $post): ?>

                                <dt><?= $this->dateTime()->html($post->created, 'Y-m-d') ?></dt>
                                <dd><?= $this->anchor($post->href, $post->title) ?></dd>

                            <?php endforeach; ?></dl>
                        </section>
                    </div>

                    <?= $this->render('prevnext') ?>

                </article>
