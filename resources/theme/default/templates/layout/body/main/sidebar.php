<aside class="Sidebar col-md-3">
    <?php foreach ($this->config->theme->sidebar ?? [] as $widget): ?>
        <?= $this->widget($widget); ?>
    <?php endforeach; ?>
</aside>
