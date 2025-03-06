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



    // echo json_encode($request->all());exit;
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Pending,In Progress,Completed,Canceled',
            ]);

            $workOrder = WoManagementModel::findOrFail($id);

            $updateData = [
                'status' => $validated['status'],
            ];

            if ($validated['status'] === 'In Progress' && !$workOrder->start_production) {
                $updateData['start_production'] = now();
            }

            if ($validated['status'] === 'Completed' && !$workOrder->finish_production) {
                $updateData['finish_production'] = now();
            }

            $workOrder->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Work order status updated!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateQty(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'qty_progress' => 'required|integer|min:0',
            ]);

            $workOrder = WoManagementModel::findOrFail($id);

            if ($workOrder->status !== 'In Progress') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update quantity. Work order is not in progress.',
                ], 400);
            }

            $workOrder->update([
                'qty_progress' => $validated['qty_progress'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantity progress updated!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update quantity: ' . $e->getMessage(),
            ], 500);
        }
    }

}
