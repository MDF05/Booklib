<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Gunakan Document Root yang sudah didefinisikan untuk path yang solid
$root = $_SERVER['DOCUMENT_ROOT'];

// Register the Composer autoloader...
require $root.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $root.'/bootstrap/app.php';
