<article class="row">
    <aside class="col-3 text-right pt-1">
        <?= $this->penders('post-meta-prepend') ?>

        <time datetime="<?= $this->dateTime()->attr($this->post->created); ?>">
            <?= $this->dateTime()->html($this->post->created, 'l') ?><br />
            <span class="display-4"><?= $this->dateTime()->html($this->post->created, 'd') ?></span><br />
            <?= $this->dateTime()->html($this->post->created, 'M Y') ?><br />
        </time>

        <address rel="author"><?= $this->escape()->html($this->post->author) ?></address>

        <ul class="list-unstyled"><?php foreach ($this->post->tags as $k => $tag): ?>
            <li class="small"><?= $this->anchor($tag->href, $tag->title); ?></li>
        <?php endforeach; ?></ul>

        <?= $this->penders('post-meta-append') ?>
    </aside>
    <section class="col-9">
        <header>
            <?= $this->penders('post-header-prepend') ?>

            <h2><?= $this->anchor(
                $this->post->href,
                $this->post->title
            ) ?></h2>

            <?= $this->penders('post-header-append') ?>
        </header>
        <?= $this->penders('post-body-prepend') ?>
        <?= $this->body($this->post); ?>
        <?= $this->penders('post-body-append') ?>
    </section>
</article>

<div class="row">
    <div class="col-3"></div>
    <div class="col-9">
        <?= $this->render('prevnext') ?>
    </div>
</div>
