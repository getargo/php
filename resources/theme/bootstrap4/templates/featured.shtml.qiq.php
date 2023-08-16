{{ setLayout(null) }}
{{ foreach ($config->featured as $title => $href): }}
<li>{{= anchor ($href, $title) }}</li>
{{ endforeach }}
