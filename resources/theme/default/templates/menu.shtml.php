
            <?php foreach ($this->config->menu as $title => $href): ?>

                <?= $this->anchor(
                    $href,
                    $title,
                    [
                        'class' => 'SiteNav__Item'
                    ]
                ); ?>

            <?php endforeach; ?>
