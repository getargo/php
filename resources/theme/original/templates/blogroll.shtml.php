
                    <?php foreach ($this->config->blogroll as $title => $href): ?>

                    <li class="LinkList__Item"><?= $this->anchor(
                        $href,
                        $title,
                        [
                            'class' => 'LinkList__ItemLink'
                        ]
                    ) ?></li>

                    <?php endforeach; ?>
