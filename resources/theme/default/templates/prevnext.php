<?php if ($this->item->prev !== null || $this->item->next !== null): ?>
    <ul class="pagination justify-content-center mb-4">
        <?php if ($this->item->prev !== null): ?>
        <li class="page-item text-left"><?=
            $this->anchorRaw($this->item->prev->href, "&laquo; {$this->item->prev->title}", ['class' => 'page-link']);
        ?></li>
        <?php endif; ?>
        <?php if ($this->item->next !== null): ?>
        <li class="page-item text-right"><?=
            $this->anchorRaw($this->item->next->href, "{$this->item->next->title} &raquo;", ['class' => 'page-link']);
        ?></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
