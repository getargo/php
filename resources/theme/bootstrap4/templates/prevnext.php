{{ if $this->item->prev !== null || $this->item->next !== null }}
    <ul class="PrevNext pagination justify-content-between mb-4">

        <li class="page-item text-left mr-1">{{ if $this->item->prev !== null }}
            {{= anchor
                $this->item->prev->href,
                '&laquo; ' . $this->item->prev->title,
                [
                    'class' => 'page-link',
                    'raw' => true,
                ]
            }}
        {{ endif }}</li>

        <li class="page-item text-right ml-1">{{ if $this->item->next !== null }}
            {{= anchor
                $this->item->next->href,
                $this->item->next->title . ' &raquo;',
                [
                    'class' => 'page-link',
                    'raw' => true
                ]
            }}
        {{ endif }}</li>

    </ul>
{{ endif }}
