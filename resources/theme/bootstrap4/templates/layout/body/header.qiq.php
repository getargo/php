<header class="Header">
    {{= penders ($this, 'layout-header-prepend') }}

    <h1><a href="/">{{= $config->general->title }}</a></h1>
    <p>{{= $config->general->tagline }}</p>

    {{= penders ($this, 'layout-header-append') }}
</header>

{{= render ('layout/body/nav') }}
