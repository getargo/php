{{ foreach ($this->months as $month): }}
<li>
    {{= anchor($month->href, $month->title) }} ({{= count ($month->posts) }})
</li>
{{ endforeach }}
