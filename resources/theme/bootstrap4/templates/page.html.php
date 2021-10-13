<article class="PageArticle">
    <header class="ArticleHeader">
        <h2>{{= anchor $this->page->href, $this->page->title }}</h2>
    </header>
    <section class="ArticleBody">
        {{= body $this->page }}
    </section>
</article>
