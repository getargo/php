<?php
use Argo\Http\Action\Setup\PostSetup;

$this->setLayout(null);
?>
<html>
<head>
    <title>Argo Setup</title>
    <link rel="stylesheet" type="text/css" href="/style.css" />
    <script src="/scripts.js"></script>
</head>

<h1>Welcome to Argo!</h1>

<p>
    Setup is a breeze: just enter a few pieces of information, and your local
    site will be working in no time!
</p>

<form onsubmit="return false;">
    <div id="submit-failure"></div>

    <table>
        <tr align="left">
            <th align="right">Folder Name</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'name',
                'value' => $this->name,
                'attribs' => [
                    'style' => 'width: 40em;',
                ],
            ]); ?></td>
        </tr>

        <tr align="left">
            <th align="right" valign="top">Blog Title</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'title',
                'value' => $this->title,
                'attribs' => [
                    'style' => 'width: 40em;',
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Blog Tagline</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'tagline',
                'value' => $this->tagline,
                'attribs' => [
                    'style' => 'width: 40em;',
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
                    'style' => 'width: 40em;',
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top">Site URL</th>
            <td><?= $this->input([
                'type' => 'text',
                'name' => 'url',
                'value' => $this->url,
                'attribs' => [
                    'style' => 'width: 40em;',
                ],
            ]); ?></td>
        </tr>

        <tr>
            <th align="right" valign="top"></th>
            <td><?= $this->routeSubmit(
                'Get Started!',
                PostSetup::CLASS
            ); ?></td>
        </tr>
    </table>
</form>
