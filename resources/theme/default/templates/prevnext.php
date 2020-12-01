<?php if ($this->item->prev !== null || $this->item->next !== null): ?>
    <ul class="PrevNext pagination justify-content-between mb-4">

        <li class="page-item text-left mr-1"><?php if ($this->item->prev !== null) {
            echo $this->anchorRaw($this->item->prev->href, "&laquo; {$this->item->prev->title}", ['class' => 'page-link']);
        } ?></li>

        <li class="page-item text-right ml-1"><?php if ($this->item->next !== null) {
            echo $this->anchorRaw($this->item->next->href, "{$this->item->next->title} &raquo;", ['class' => 'page-link']);
        } ?></li>

    </ul>
<?php endif; ?>
