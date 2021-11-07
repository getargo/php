{{= '\<\?' }}xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">

    <title>{{= $this->config->general->title }}</title>
    <link href="{{a $this->config->general->url }}" />
    <updated>{{= dateTime ('now', DATE_ATOM) }}</updated>

    {{ foreach ($this->postIndex->posts as $post): }}
    <entry>
        <title>{{= $post->title }}</title>
        <link href="{{a $this->config->general->url . $post->href }}" />
        <updated>{{= dateTime ($post->lastUpdated, DATE_ATOM) }}</updated>
        <summary>{{h substr (
            trim(strip_tags($this->body($post))),
            0,
            250
        ) }}...</summary>
    </entry>
    {{ endforeach }}
</feed>
