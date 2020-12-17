            <?php if ($this->item->prev !== null || $this->item->next !== null): ?>
                <ul class="Pagination">
                    <?php if ($this->item->prev !== null): ?>
                        <li class="Pagination__Item">
                            <a href="<?=$this->item->prev->href?>" class="Pagination__Link">
                                &laquo; <?=$this->item->prev->title?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->item->next !== null): ?>
                        <li class="Pagination__Item">
                            <a href="<?=$this->item->next->href?>" class="Pagination__Link">
                                <?=$this->item->next->title?> &raquo;
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
