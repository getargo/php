<title><?php
    $title = $this->escape()->html($this->config->general->title);
    $title .= isset($this->item->title)
        ? ' | ' . $this->escape()->html($this->item->title)
        : '';
    echo $title;
?></title>
