<?='<?';?>xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">

    <title><?= $this->config->general->title . ' | ' . $this->tag->title ?></title>
    <link href="<?= $this->config->general->url . $this->tag->href ?>" />
    <updated><?= $this->dateTime()->html('now', DATE_ATOM) ?></updated>
    <?php for (
        $i = 0;
        $i < $this->config->general->perPage && $i < count($this->tag->posts);
        $i ++
    ): $post = $this->tag->posts[$i]; ?>

    <entry>
        <title><?= $post->title ?></title>
        <link href="<?= $this->config->general->url . $post->href ?>" />
        <updated><?= $this->dateTime()->html($post->lastUpdated, DATE_ATOM) ?></updated>
        <summary><?= $this->escape()->html(
            substr(
                trim(strip_tags($this->body($post))),
                0,
                250
            )
        ) ?>...</summary>
    </entry>
    <?php endfor; ?>

</feed>
