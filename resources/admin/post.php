<?php
use Argo\Http\Action\Post\DeletePost;
use Argo\Http\Action\Post\PostPost;

$this->header = 'Post';
?>
<div class="card card-outline">
    <div class="card-body">
        {{= render ('item', [
            'item' => $this->post,
            'routeSubmitPost' => PostPost::CLASS,
            'routeSubmitDelete' => DeletePost::CLASS,
        ]) }}
</div>

<div class="card card-outline">
    <div class="card-body">
        <h4>{{= $this->post->title }}</h4>
        {{= bodyPreview ($this->post) }}
    </div>
</div>
