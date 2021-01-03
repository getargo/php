<?='<?';?>xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">

    <title><?= $this->config->general->title ?></title>
    <link href="<?= $this->config->general->url ?>" />
    <updated><?= $this->dateTime()->html('now', DATE_ATOM) ?></updated>

    <?php foreach ($this->postIndex->posts as $post): ?>
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
    <?php endforeach; ?>

</feed>
