<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Setup writable storage subdirectories & SQLite database when running on Vercel / serverless
        if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('VERCEL') || (!app()->runningInConsole() && !is_writable(storage_path()))) {
            $tmpPath = '/tmp';
            
            foreach ([
                $tmpPath . '/storage/framework/views',
                $tmpPath . '/storage/framework/cache',
                $tmpPath . '/storage/framework/sessions',
                $tmpPath . '/storage/logs',
            ] as $dir) {
                if (!is_dir($dir)) {
                    @mkdir($dir, 0777, true);
                }
            }

            Config::set('view.compiled', $tmpPath . '/storage/framework/views');
            Config::set('cache.stores.file.path', $tmpPath . '/storage/framework/cache');
            Config::set('session.files', $tmpPath . '/storage/framework/sessions');

            if (env('DB_CONNECTION', 'sqlite') === 'sqlite') {
                $dbPath = $tmpPath . '/database.sqlite';
                if (!file_exists($dbPath) || filesize($dbPath) === 0) {
                    $originalDb = database_path('database.sqlite');
                    if (file_exists($originalDb) && filesize($originalDb) > 0) {
                        @copy($originalDb, $dbPath);
                    } else {
                        @touch($dbPath);
                    }
                }
                Config::set('database.connections.sqlite.database', $dbPath);
                DB::purge('sqlite');
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-seed database during web requests if running with empty or unmigrated SQLite database
        if (!app()->runningInConsole()) {
            try {
                if (env('DB_CONNECTION', 'sqlite') === 'sqlite') {
                    $dbFile = config('database.connections.sqlite.database');
                    if ($dbFile && !file_exists($dbFile)) {
                        @touch($dbFile);
                    }
                }

                if (!Schema::hasTable('users') || User::count() === 0) {
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed', ['--force' => true]);
                }
            } catch (\Throwable $e) {
                // Silently handle
            }
        }
    }
}
