{{ foreach $this->config->featured as $title => $href }}
<li>{{= anchor $href, $title }}</li>
{{ endforeach }}
