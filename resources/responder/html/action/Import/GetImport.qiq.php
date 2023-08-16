{{ use Argo\Sapi\Http\Action\Import\PostImport }}
{{ $header = 'Import WordPress Content' }}

<div class="card card-outline">
    <div class="card-body">
        <p><strong>This feature is EXPERIMENTAL and may be subject to change.</strong></p>

        <form onsubmit="return false;">
            <div id="submit-failure"></div>

            <p>{{= fileField (
                name: 'wpxml',
            ) }}</p>

            <p>{{= submitAction ('Import WordPress', PostImport::CLASS) }}</p>
        </form>

        <pre id="submit-stream"></pre>
    </div>
</div>
