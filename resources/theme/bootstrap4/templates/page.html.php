<article class="PageArticle">
    <header class="ArticleHeader">
        <h2><?= $this->anchor($this->page->href, $this->page->title); ?></h2>
    </header>
    <section class="ArticleBody">
        <?= $this->body($this->page) ?>
    </section>
</article>
