{{ setLayout(null) }}
{{ foreach ($config->blogroll as $title => $href): }}
<li>{{= anchor ($href, $title) }}</li>
{{ endforeach }}
