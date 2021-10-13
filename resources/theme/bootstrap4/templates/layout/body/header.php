<header class="Header">
    {{= penders $this, 'layout-header-prepend' }}

    <h1><a href="/">{{= $this->config->general->title }}</a></h1>
    <p>{{= $this->config->general->tagline }}</p>

    {{= penders $this, 'layout-header-append' }}
</header>

{{= render 'layout/body/nav' }}
