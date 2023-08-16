<article class="PageArticle">
    <header class="ArticleHeader">
        <h2>{{= anchor ($page->href, $page->title) }}</h2>
    </header>
    <section class="ArticleBody">
        {{= body ($page) }}
    </section>
</article>
