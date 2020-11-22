<article class="row">
    <aside class="col-3 text-right pt-1">
        <?= $this->renderAll($this->config->theme->post_meta_prepend ?? []) ?>

        <time datetime="<?= $this->dateTime()->attr($this->post->created); ?>">
            <?= $this->dateTime()->html($this->post->created, 'l') ?><br />
            <span class="display-4"><?= $this->dateTime()->html($this->post->created, 'd') ?></span><br />
            <?= $this->dateTime()->html($this->post->created, 'M Y') ?><br />
        </time>

        <address rel="author"><?= $this->escape()->html($this->post->author) ?></p>

        <ul class="list-unstyled"><?php foreach ($this->post->tags as $k => $tag): ?>
            <li class="small"><?= $this->anchor($tag->href, $tag->title); ?></li>
        <?php endforeach; ?></ul>

        <?= $this->renderAll($this->config->theme->post_meta_append ?? []) ?>
    </aside>
    <section class="col-9">
        <header>
            <?= $this->renderAll($this->config->theme->post_header_prepend ?? []) ?>

            <h2><?= $this->anchor(
                $this->post->href,
                $this->post->title
            ) ?></h2>

            <?= $this->renderAll($this->config->theme->post_header_append ?? []) ?>
        </header>
        <?= $this->renderAll($this->config->theme->post_body_prepend ?? []) ?>
        <?= $this->body($this->post); ?>
        <?= $this->renderAll($this->config->theme->post_body_append ?? []) ?>
    </section>
</article>

<div class="row">
    <div class="col-3"></div>
    <div class="col-9">
        <?= $this->render('prevnext') ?>
    </div>
</div>
