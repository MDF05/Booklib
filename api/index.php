<?php

// Definisikan Document Root sebagai parent directory dari 'api' (Root Proyek Laravel)
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

// Tambahkan ENV Laravel_ENV jika diperlukan (Vercel PHP sering membutuhkannya)
$_SERVER['APP_ENV'] = 'production';
$_SERVER['LARAVEL_ENV'] = 'production';
$_SERVER['APP_URL'] = 'https://' . $_SERVER['HTTP_HOST'];

// Lanjutkan memuat index.php dari public/
require __DIR__ . "/../public/index.php";
