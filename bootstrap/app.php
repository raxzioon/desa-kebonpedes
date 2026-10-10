<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // PERANGKAP ERROR: Paksa tampilkan teks asli sebelum sistem crash
        $exceptions->renderable(function (\Throwable $e) {
            echo "<div style='font-family: sans-serif; padding: 20px; background: #ffebee;'>";
            echo "<h2 style='color: #c62828;'>TERTANGKAP! Ini Error Aslinya:</h2>";
            echo "<strong>Pesan:</strong> " . $e->getMessage() . "<br><br>";
            echo "<strong>Lokasi:</strong> " . $e->getFile() . " (Baris " . $e->getLine() . ")<br><br>";
            echo "</div>";
            exit; // Hentikan proses agar tidak memicu error 'view'
        });
    })->create();