<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app->handleRequest(Illuminate\Http\Request::capture());