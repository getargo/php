<title>{{h
    $this->config->general->title
}}{{h
    isset($this->item->title)
        ? ' | ' . $this->item->title
        : ''
}}</title>
