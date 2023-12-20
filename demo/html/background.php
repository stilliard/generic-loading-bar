<?php

use GLB\DisplayHandler\ConsoleDisplayHandler;

require_once __DIR__ . '/init.php';

$loading->setDisplayHandler(ConsoleDisplayHandler::class);

for ($i = 0; $i <= 100; $i++) {
    $loading->set($i);
    echo $loading->display();
    usleep(100000);
}
