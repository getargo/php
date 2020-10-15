
    <footer class="SiteFooter">

        <?= $this->render('templates', $this->config->theme->layout_footer_prepend ?? []) ?>

        <p>Built with Argo.</p>

        <?= $this->render('templates', $this->config->theme->layout_footer_append ?? []) ?>

    </footer>
