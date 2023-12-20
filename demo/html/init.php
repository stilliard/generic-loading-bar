<?php

use GLB\DataHandler\RedisDataHandler;
use GLB\DisplayHandler\HTMLDisplayHandler;
use GLB\LoadingBar;

require_once __DIR__ . '/../../vendor/autoload.php';

$loading = new LoadingBar([
    'displayHandler' => HTMLDisplayHandler::class,
    'dataHandler' => RedisDataHandler::class,
    'redis_host' => 'localhost',
    'redis_port' => 6379,
    'codename' => 'html-demo',
]);
