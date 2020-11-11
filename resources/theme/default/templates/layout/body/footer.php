<footer class="p-4">
    <?= $this->render('templates', $this->config->theme->layout_footer_prepend ?? []); ?>
    <p class="m-0 text-center">Built with <?= $this->anchor(
        'https://github.com/getargo/app',
        'Argo',
        ['_target' => 'blank']
    ); ?>.</p>
    <?= $this->render('templates', $this->config->theme->layout_footer_append ?? []); ?>
</footer>
