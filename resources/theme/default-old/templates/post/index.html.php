                <article class="Article Article--HasMeta">
                    <aside class="Article__Meta">

                        <?= $this->renderAll($this->config->theme->post_meta_prepend ?? []) ?>

                        <div class="Article__MetaSmall"><?= $this->dateTime()->html($this->post->created, 'l') ?></div>
                        <div class="Article__MetaLarge"><?= $this->dateTime()->html($this->post->created, 'd') ?></div>
                        <div class="Article__MetaSmall"><?= $this->dateTime()->html($this->post->created, 'F Y') ?></div>
                        <div class="Article__MetaSmall"><?= $this->escape()->html($this->post->author) ?></div>
                        <div class="Article__MetaSmall">
                            <?php foreach ($this->post->tags as $k => $tag): ?>
                                <?php if (isset($tag->href) && isset($tag->title)): ?>
                                    <?= $this->anchor($tag->href, $tag->title) . ($k + 1 < count($this->post->tags) ? ', ' : '') ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <?= $this->renderAll($this->config->theme->post_meta_append ?? []) ?>

                    </aside>
                    <div class="Article__Main">
                        <header class="Article__Header">

                            <?= $this->renderAll($this->config->theme->post_header_prepend ?? []) ?>

                            <h1 class="Article__Heading"><?= $this->anchor(
                                $this->post->href,
                                $this->post->title,
                                [
                                    'class' => 'Article__HeadingLink'
                                ]
                            ) ?></h1>
                            <!-- Article subheading can be omitted
                            <h2 class="Article__SubHeading">
                                Pellentesque molestie nunc id sagittis venenatis. Curabitur non porttitor dolor.
                            </h2>
                            -->

                            <?= $this->renderAll($this->config->theme->post_header_append ?? []) ?>

                        </header>
                        <section class="Article__Body">
                            <?= $this->renderAll($this->config->theme->post_body_prepend ?? []) ?>
                            <?= $this->body($this->post) ?>
                            <?= $this->renderAll($this->config->theme->post_body_append ?? []) ?>
                        </section>
                        <footer class="Article__Footer">
                            <?= $this->renderAll($this->config->theme->post_footer_prepend ?? []) ?>
                            <?= $this->renderAll($this->config->theme->post_footer_append ?? []) ?>
                        </footer>

                        <?= $this->render('prevnext') ?>

                    </div>

                </article>
