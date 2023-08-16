{{ if ($item->prev !== null || $item->next !== null): }}
    <ul class="PrevNext pagination justify-content-between mb-4">
        <li class="page-item text-left mr-1">{{ if ($item->prev !== null): }}
            <a {{a ['href' => $item->prev->href, 'class' => 'page-link'] }}>&laquo; {{h $item->prev->title }}</a>
        {{ endif }}</li>

        <li class="page-item text-right ml-1">{{ if ($item->next !== null): }}
            <a {{a ['href' => $item->next->href, 'class' => 'page-link'] }}>{{h $item->next->title }} &raquo;</a>
        {{ endif }}</li>

    </ul>
{{ endif }}
