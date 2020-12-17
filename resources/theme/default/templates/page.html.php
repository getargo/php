                <article class="Article">
                    <div class="Article__Main">
                        <header class="Article__Header">
                            <h1 class="Article__Heading"><?= $this->anchor(
                                $this->page->href,
                                $this->page->title,
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
                            <?= $this->body($this->page) ?>
                        </section>
                    </div>
                </article>
