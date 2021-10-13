<title><?php
    $title = $this->h($this->config->general->title);
    $title .= isset($this->item->title)
        ? ' | ' . $this->h($this->item->title)
        : '';
    echo $title;
?></title>
