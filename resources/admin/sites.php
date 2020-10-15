<?php
use Argo\Http\Action\Site\GetSite;
use Argo\Http\Action\Site\PostSite;
?>
<h1>Sites</h1>

<table>

    <tr>
        <th>Name</th>
        <th>Folder</th>
        <th></th>
    </tr>

<?php foreach ($this->sites as $name => $dir): ?>
    <tr>
        <td><?= $this->escape()->html($name); ?></td>
        <td><?= $this->escape()->html($dir); ?></td>
        <td><?php
            if ($dir === $this->docroot) {
                echo "(current site)";
            } else {
                echo $this->anchor(
                    $this->route(GetSite::CLASS, $name),
                    'Swap'
                );
            }
        ?></td>
    </tr>
<?php endforeach; ?>
</table>

<h2>Create New Site</h2>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <table>
        <tr align="left">
            <th align="right">Folder Name</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'name',
                'value' => '',
                'attribs' => [
                    'size' => 60,
                ],
            ]); ?></td>
        </tr>

        <tr align="left">
            <th align="right" valign="top">Blog Title</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => '',
                'attribs' => [
                    'size' => 60,
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Blog Tagline</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'tagline',
                'value' => '',
                'attribs' => [
                    'size' => 60,
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Author Name</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'author',
                'value' => $this->author,
                'attribs' => [
                    'size' => 60,
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Site URL</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'url',
                'value' => '',
                'attribs' => [
                    'size' => 60,
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th></th>
            <td><?= $this->routeSubmit(
                'Create',
                PostSite::CLASS
            ); ?></td>
        </tr>
    </table>
</form>
