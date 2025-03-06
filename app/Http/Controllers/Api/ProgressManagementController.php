<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrderProgressLog;
use Illuminate\Http\Request;

class ProgressManagementController extends Controller
{
    public function showProgress($workOrderId)
    {
        $progressLogs = WorkOrderProgressLog::where('work_order_id', $workOrderId)
            ->with('operator')
            ->orderBy('created_at', 'asc')
            ->get();
    
        if ($progressLogs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No progress found for this Work Order.'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'data' => $progressLogs
        ]);
    }
    
}
