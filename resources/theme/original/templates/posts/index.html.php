                <?php foreach ($this->postIndex->posts as $post): ?>

                <!-- Repeating article content -->

                <article class="Article Article--HasMeta">
                    <!-- If Meta Aside is being omitted, remove Article--HasMeta class from Article -->
                    <aside class="Article__Meta">
                        <div class="Article__MetaSmall"><?= $this->dateTime()->html($post->created, 'l') ?></div>
                        <div class="Article__MetaLarge"><?= $this->dateTime()->html($post->created, 'd') ?></div>
                        <div class="Article__MetaSmall"><?= $this->dateTime()->html($post->created, 'F Y') ?></div>
                        <div class="Article__MetaSmall"><?= $this->escape()->html($post->author) ?></div>
                        <div class="Article__MetaSmall"><?php foreach ($post->tags as $k => $tag): ?>
                            <?= $this->anchor($tag->href, $tag->title) . ($k + 1 < count($post->tags) ? ', ' : '') ?>
                        <?php endforeach; ?>
                        </div>
                    </aside>
                    <!-- /End omit meta -->
                    <div class="Article__Main">
                        <header class="Article__Header">
                            <h1 class="Article__Heading"><?= $this->anchor(
                                $post->href,
                                $post->title,
                                [
                                    'class' => 'Article__HeadingLink'
                                ]
                            ) ?></h1>
                            <!-- Article subheading can be omitted
                            <h2 class="Article__SubHeading">
                                Pellentesque molestie nunc id sagittis venenatis. Curabitur non porttitor dolor.
                            </h2>
                            -->
                        </header>
                        <section class="Article__Body">
                            <?= $this->bodyLess($post) ?>
                        </section>
                    </div>
                </article>

                <!-- /Repeating article content -->

                <?php endforeach; ?>

                <?= $this->render('prevnext') ?>
