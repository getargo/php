<aside class="Sidebar col-md-3">
    {{ foreach ($config->theme->sidebar ?? [] as $widget): }}
        {{= render ("widgets/{$widget}") }}
    {{ endforeach }}
</aside>
