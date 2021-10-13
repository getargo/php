{{ use Argo\Http\Action\Config\PostConfig }}
{{ $this->header = ucfirst($this->name) . ' Config' }}

<div class="card card-outline">
    <div class="card-body">
        <form onsubmit="return false;">
            <p>{{= formTextarea ([
                'name' => 'text',
                'value' => $this->text,
                'class' => 'form-control h-100',
                'style' => 'font-size: 85%;',
                'rows' => '18',
            ]) }}</p>

            <p>{{= routeSubmit ('Save', PostConfig::CLASS, $this->name) }}</p>

            <pre id="submit-failure"></pre>
        </form>
      </div>
</div>
