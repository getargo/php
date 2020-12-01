<header class="Header">
    <?= $this->penders('layout-header-prepend') ?>

    <h1><?= $this->anchorRaw('/', $this->config->general->title); ?></h1>
    <p><?= $this->config->general->tagline; ?></p>

    <?= $this->penders('layout-header-append') ?>
</header>

<?= $this->render('layout/body/nav'); ?>
