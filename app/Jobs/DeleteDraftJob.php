<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\AbstractDraft;

class DeleteDraftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $serialNumber;
    private string $userRegNo;

    /**
     * Create a new job instance.
     *
     * @param string $serialNumber
     * @param string $userRegNo
     */
    public function __construct(string $serialNumber, string $userRegNo)
    {
        $this->serialNumber = $serialNumber;
        $this->userRegNo = $userRegNo;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Locate the draft by serial number and user registration number
            $draft = AbstractDraft::where('serial_number', $this->serialNumber)
                ->where('user_reg_no', $this->userRegNo)
                ->first();

            if ($draft) {
                // Delete the draft
                $draft->delete();
                return response()->json([
                    'message' => 'Draft deleted successfully',
                    'status' => 'success',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Draft not found',
                    'status' => 'error',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the draft',
                'status' => 'error',
            ], 500);
        }
    }
}