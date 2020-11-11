<?php
$style = '';
if ($this->config->theme->layout_header_image ?? false) {
    $style .= "background-image: url('{$this->config->theme->layout_header_image}'); ";
}
if ($this->config->theme->layout_header_color ?? false) {
    $style .= "color: {$this->config->theme->layout_header_color}; ";
}
$style .= $this->config->theme->layout_header_style ?? '';
$class = $this->config->theme->layout_header_class ?? '';
?>
<header class="<?= $class; ?>" style="<?= $style; ?>">
    <?= $this->render('templates', $this->config->theme->layout_header_prepend ?? []) ?>
    <h1><?= $this->config->general->title; ?></h1>
    <p class=><?= $this->config->general->tagline; ?></p>
    <?= $this->render('templates', $this->config->theme->layout_header_append ?? []) ?>
</header>

<?= $this->render('layout/body/nav'); ?>
