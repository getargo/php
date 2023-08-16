{{ use Argo\Sapi\Http\Action\Config\PostConfig }}
{{ $header = ucfirst($name) . ' Config' }}

<div class="card card-outline">
    <div class="card-body">
        <form onsubmit="return false;">
            <p>{{= textarea (
                name: 'text',
                value: $text,
                class: 'form-control h-100',
                style: 'font-size: 85%;',
                rows: '18',
            ) }}</p>

            <p>{{= submitAction ('Save', PostConfig::CLASS, $name) }}</p>

            <pre id="submit-failure"></pre>
        </form>
      </div>
</div>
