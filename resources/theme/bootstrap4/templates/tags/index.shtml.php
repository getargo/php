{{ foreach ($this->tags as $tag): }}
<li>
    {{= anchor ($tag->href, $tag->title) }}
    {{= '(' . count($tag->posts) . ')' }}
</li>
{{ endforeach }}
