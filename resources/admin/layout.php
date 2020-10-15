<?php
use Argo\Http\Action\Config\GetConfig;
use Argo\Http\Action\Get;
use Argo\Http\Action\Import\GetImport;
use Argo\Http\Action\Tags\GetTags;
use Argo\Http\Action\Pages\GetPages;
use Argo\Http\Action\Posts\GetPosts;
use Argo\Http\Action\Sites\GetSites;
?>
<html>
<head>
    <title>Argo Admin</title>
    <link rel="stylesheet" type="text/css" href="/style.css" />
    <script src="/scripts.js"></script>
</head>

<body>
    <table border="0" width="100%">
        <tr>
            <td width="20%" valign="top">
                <p><?= $this->anchor($this->route(Get::CLASS), 'Dashboard'); ?></p>
                <p><?= $this->anchor($this->route(GetPosts::CLASS), 'Posts'); ?></p>
                <p><?= $this->anchor($this->route(GetPages::CLASS), 'Pages'); ?></p>
                <p><?= $this->anchor($this->route(GetTags::CLASS), 'Tags'); ?></p>
                <p><?= $this->anchor($this->route(GetConfig::CLASS, 'general'), 'General Config'); ?></p>
                <p><?= $this->anchor($this->route(GetConfig::CLASS, 'theme'), 'Theme Config'); ?></p>
                <p><?= $this->anchor($this->route(GetConfig::CLASS, 'menu'), 'Menu Config'); ?></p>
                <p><?= $this->anchor($this->route(GetConfig::CLASS, 'blogroll'), 'Blogroll Config'); ?></p>
                <p><?= $this->anchor($this->route(GetConfig::CLASS, 'sync'), 'Sync Config'); ?></p>
                <p><?= $this->anchor($this->route(GetImport::CLASS), 'Import'); ?></p>
                <p><?= $this->anchor($this->route(GetSites::CLASS), 'Sites'); ?></p>
            </td>
            <td width="80%" valign="top">
                <?= $this->getContent(); ?>
            </td>
        </tr>
    </table>
</body>
</html>
