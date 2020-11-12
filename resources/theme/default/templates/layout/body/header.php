<?php
$image = $this->config->theme->layout_header_image ?? '';
if ($image !== '') {
    $image = "background-image: url('{$image}'); ";
}

$color = $this->config->theme->layout_header_color ?? '';
if ($color !== '') {
    $color = "color: {$this->config->theme->layout_header_color}; ";
}
$style = "{$image} {$color} " . ($this->config->theme->layout_header_style ?? '');
$class = $this->config->theme->layout_header_class ?? '';
?>

<header class="<?= $class; ?>" style="<?= $style; ?>">
    <?= $this->render('templates', $this->config->theme->layout_header_prepend ?? []) ?>

    <h1><?= $this->anchorRaw('/', $this->config->general->title, [
        'style' => $color,
    ]); ?></h1>

    <p><?= $this->config->general->tagline; ?></p>

    <?= $this->render('templates', $this->config->theme->layout_header_append ?? []) ?>
</header>

<?= $this->render('layout/body/nav'); ?>
