<footer class="Footer p-4">
    {{= penders ($this, 'layout-footer-prepend') }}
    <p class="m-0 text-center">Built with {{= anchor (
        'https://github.com/getargo/app',
        'Argo',
        ['_target' => 'blank']
    ) }}.</p>
    {{= penders ($this, 'layout-footer-append') }}
</footer>
