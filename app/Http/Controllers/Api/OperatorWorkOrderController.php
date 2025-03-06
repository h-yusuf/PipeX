<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WoManagementModel;
use Illuminate\Http\Request;

class OperatorWorkOrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $operator = auth()->user();
             // echo json_encode($operator);
            $status = $request->query('status'); 
            $query = WoManagementModel::where('operator_id', $operator->id)
                ->with('product')
                ->orderBy('updated_at', 'desc');
    
            if ($status) {
                $query->where('status', $status);
            }
    
            $workOrders = $query->get();
    
            return response()->json([
                'success' => true,
                'data' => $workOrders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch work orders: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    

    public function show($id)
    {
        try {
            $workOrder = WoManagementModel::with(['product', 'operator'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $workOrder,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch work order: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function     update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Pending,In Progress,Completed,Canceled',
            ]);

            $workOrder = WoManagementModel::findOrFail($id);
            $workOrder->update([
                'status' => $validated['status'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work order updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update work order: ' . $e->getMessage(),
            ], 500);
        }
    }
}
