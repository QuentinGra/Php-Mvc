<?php

use App\Autoloader;
use App\Core\Main;


define('ROOT', dirname(__DIR__));

require_once ROOT . '/Autoloader.php';

Autoloader::register();

$app = new Main();

$app->start();
