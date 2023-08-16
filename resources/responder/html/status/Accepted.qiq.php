<?php
$this->setLayout(null);
$this->response()->setHeader('Content-Type', 'text/plain');
$this->response()->setContent($callable ?? null);
