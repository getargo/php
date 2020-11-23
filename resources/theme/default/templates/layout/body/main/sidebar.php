<aside class="col-md-3">
    <?php foreach ($this->config->theme->sidebar as $widget): ?>
        <section class="card my-4">
            <?= $this->widget($widget); ?>
        </section>
    <?php endforeach; ?>
</aside>
