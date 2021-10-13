{{ foreach $this->config->menu as $title => $href }}
    <li class="MenuItem nav-item">
        {{= anchor $href, $title, ['class' => 'nav-link'] ~}}
    </li>
{{ endforeach }}
