<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CleanupSessionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $sessionKeys;
    public $tries = 3;
    public $timeout = 30;

    public function __construct(array $sessionKeys)
    {
        $this->sessionKeys = $sessionKeys;
    }

    public function handle()
    {
        try {
            foreach ($this->sessionKeys as $key) {
                session()->forget($key);
            }

            Log::info('Session cleanup completed', [
                'keys' => $this->sessionKeys
            ]);

        } catch (\Exception $e) {
            Log::error('Session cleanup failed', [
                'keys' => $this->sessionKeys,
                'error' => $e->getMessage()
            ]);

            // Rethrow the exception to trigger a retry
            throw $e;
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Session cleanup job failed permanently', [
            'keys' => $this->sessionKeys,
            'error' => $exception->getMessage()
        ]);
    }
}