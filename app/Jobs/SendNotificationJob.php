<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $userRegNo;
    private array $data;
    public $tries = 3; // Add retry attempts
    public $timeout = 60; // Set timeout

    public function __construct(string $userRegNo, array $data)
    {
        $this->userRegNo = $userRegNo; // Fixed variable name
        $this->data = $data;
    }

    public function handle()
    {
        try {
            $user = User::where('reg_no', $this->userRegNo)->firstOrFail();
            
            if (!$user) {
                throw new \Exception("User not found with reg_no: {$this->userRegNo}");
            }

            $user->notify(new NewUserNotification($this->data));
            
            Log::info('Notification sent successfully', [
                'user_reg_no' => $this->userRegNo,
                'notification_type' => 'NewUserNotification',
                'message' => $this->data['message'] ?? 'No message provided'
            ]);
        } catch (\Exception $e) {
            Log::error('Notification failed', [
                'user_reg_no' => $this->userRegNo,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e; // Re-throw to trigger job retry
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Notification job failed permanently', [
            'user_reg_no' => $this->userRegNo,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
