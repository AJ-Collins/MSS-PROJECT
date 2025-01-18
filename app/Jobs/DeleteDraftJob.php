<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteDraftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $serialNumber;

    public function __construct(string $serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    public function handle()
    {
        try {
            // Your draft deletion logic here
            Log::info('Draft deleted successfully', ['serial_number' => $this->serialNumber]);
        } catch (\Exception $e) {
            Log::error('Draft deletion failed', [
                'serial_number' => $this->serialNumber,
                'error' => $e->getMessage()
            ]);
        }
    }
}