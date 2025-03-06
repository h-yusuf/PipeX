<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WoManagementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportManagementController extends Controller
{
    public function reportRekapWorkOrder()
    {
        try {
            $rekap = WoManagementModel::select(
                    'product_id',
                    DB::raw("SUM(CASE WHEN status = 'Pending' THEN quantity ELSE 0 END) as total_pending"),
                    DB::raw("SUM(CASE WHEN status = 'In Progress' THEN quantity ELSE 0 END) as total_in_progress"),
                    DB::raw("SUM(CASE WHEN status = 'Completed' THEN quantity ELSE 0 END) as total_completed"),
                    DB::raw("SUM(CASE WHEN status = 'Canceled' THEN quantity ELSE 0 END) as total_canceled")
                )
                ->groupBy('product_id')
                ->with('product:id,product_name')
                ->get()
                ->map(function ($item) {
                    return [
                        'product_name' => $item->product->product_name ?? 'Unknown',
                        'total_pending' => $item->total_pending,
                        'total_in_progress' => $item->total_in_progress,
                        'total_completed' => $item->total_completed,
                        'total_canceled' => $item->total_canceled,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $rekap,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch rekap work order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function reportOperatorResult()
    {
        try {
            $hasil = WoManagementModel::select(
                    'operator_id',
                    'product_id',
                    DB::raw('SUM(quantity) as total_completed')
                )
                ->where('status', 'Completed')
                ->groupBy('operator_id', 'product_id')
                ->with([
                    'operator:id,name',
                    'product:id,product_name'
                ])
                ->get()
                ->map(function ($item) {
                    return [
                        'operator_name' => $item->operator->name ?? 'Unknown',
                        'product_name' => $item->product->product_name ?? 'Unknown',
                        'total_completed' => $item->total_completed,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $hasil,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch operator result: ' . $e->getMessage(),
            ], 500);
        }
    }
}
