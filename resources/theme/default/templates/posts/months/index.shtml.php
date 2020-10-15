
                    <?php foreach ($this->months as $month): ?>

                    <li class="LinkList__Item"><?=
                        $this->anchor(
                            $month->href,
                            $month->title . ' (' . count($month->posts) . ')',
                            [
                                'class' => 'LinkList__ItemLink'
                            ]
                        )
                    ?></li>

                    <?php endforeach; ?>
