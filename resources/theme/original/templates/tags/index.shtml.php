
                    <?php foreach ($this->tags as $tag): ?>

                    <li class="LinkList__Item"><?=
                        $this->anchor(
                            $tag->href,
                            $tag->title . ' (' . count($tag->posts) . ')',
                            [
                                'class' => 'LinkList__ItemLink'
                            ]
                        )
                    ?></li>

                    <?php endforeach; ?>
