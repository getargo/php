<footer class="p-4">
    <?= $this->penders('layout-footer-prepend'); ?>
    <p class="m-0 text-center">Built with <?= $this->anchor(
        'https://github.com/getargo/app',
        'Argo',
        ['_target' => 'blank']
    ); ?>.</p>
    <?= $this->penders('layout-footer-append'); ?>
</footer>
