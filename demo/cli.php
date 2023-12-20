<?php

// Simple CLI demo showing 2 different display handlers

use GLB\LoadingBar;
use GLB\DisplayHandler\ConsoleDisplayHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$loading = new LoadingBar;

echo "Default echo display output:\n";
for ($i = 0; $i <= 100; $i++) {
    $loading->set($i);
    echo $loading->display() . "\r";
    usleep(100000);
}

echo "\n";

echo "Console display output:\n";
$loading->setDisplayHandler(ConsoleDisplayHandler::class);
for ($i = 0; $i <= 100; $i++) {
    $loading->set($i);
    echo $loading->display();
    usleep(100000);
}

echo "Done!\n";
