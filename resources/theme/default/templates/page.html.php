<article>
    <header>
        <h2><?= $this->anchor($this->page->href, $this->page->title); ?></h2>
    </header>
    <section>
        <?= $this->body($this->page) ?>
    </section>
</article>
