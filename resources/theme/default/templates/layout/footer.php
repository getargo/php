
    <footer class="SiteFooter">

        <?= $this->render('templates', $this->config->theme->layout_footer_prepend ?? []) ?>

        <p>Built with <?= $this->anchor('https://github.com/getargo/app', 'Argo'); ?></p>

        <?= $this->render('templates', $this->config->theme->layout_footer_append ?? []) ?>

    </footer>
