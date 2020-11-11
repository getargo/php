<header>
    <?= $this->render('templates', $this->config->theme->layout_header_prepend ?? []) ?>
    <h1><?= $this->config->general->title; ?></h1>
    <p class=><?= $this->config->general->tagline; ?></p>
    <?= $this->render('templates', $this->config->theme->layout_header_append ?? []) ?>
</header>

<?= $this->render('layout/body/nav'); ?>
