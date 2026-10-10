<?php
try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $request = Illuminate\Http\Request::capture();
    $response = $app->handleRequest($request);
    $response->send();
} catch (\Throwable $e) {
    echo "<h1>TERTANGKAP!</h1>";
    echo "<h3>Pesan: " . $e->getMessage() . "</h3>";
    echo "<p>Lokasi: " . $e->getFile() . " (Baris " . $e->getLine() . ")</p>";
}