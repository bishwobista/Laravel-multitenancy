<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Models\Tenant;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $tenant = Tenant::current();

        $path = storage_path('logs/tenants/' . $tenant->id . '/tenant.log');

        if (!file_exists(dirname($path))) {
            if (!mkdir($concurrentDirectory = dirname($path), 0755, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
        config([
            'logging.channels.tenant_log' => [
                'driver' => 'single',
                'path' => $path,
                'level' => 'info',
            ]
        ]);

        Log::channel('tenant_log')->info("Hello from tenant $tenant->name");
        Log::channel('tenant_log')->info('Using database ' . config('database.connections.tenant.database'));
    }
}
