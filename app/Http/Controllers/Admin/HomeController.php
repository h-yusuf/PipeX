<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WoManagementModel;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $jumlah_user = User::where('role_id', '3')->count();

        // Summary card (current month)
        $total_plan_wo = WoManagementModel::where('status', 'Pending')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $total_wo_in_progress = WoManagementModel::where('status', 'In Progress')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $total_wo_completed = WoManagementModel::where('status', 'Completed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $total_wo_canceled = WoManagementModel::where('status', 'Canceled')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Yearly chart (all products by status)
        $yearly = WoManagementModel::selectRaw('YEAR(created_at) as year, status, COUNT(*) as total')
            ->groupBy('year', 'status')
            ->orderBy('year')
            ->get()
            ->groupBy('year')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'total' => $item->total,
                    ];
                });
            });

        // Monthly chart (current year)
        $monthly = WoManagementModel::selectRaw('MONTH(created_at) as month, status, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get()
            ->groupBy('month')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'total' => $item->total,
                    ];
                });
            });

        // Weekly chart (current year)
        $weekly = WoManagementModel::selectRaw('WEEK(created_at) as week, status, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('week', 'status')
            ->orderBy('week')
            ->get()
            ->groupBy('week')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'total' => $item->total,
                    ];
                });
            });

        // Completed chart (all time) with products
        $completed = WoManagementModel::with('product')
            ->where('status', 'Completed')
            ->orderBy('created_at')
            ->get()
            ->groupBy('product.name');

        // In Progress chart (all time) with products
        $inProgress = WoManagementModel::with('product')
            ->where('status', 'In Progress')
            ->orderBy('created_at')
            ->get()
            ->groupBy('product.name');

        // Canceled chart (all time) with products
        $canceled = WoManagementModel::with('product')
            ->where('status', 'Canceled')
            ->orderBy('created_at')
            ->get()
            ->groupBy('product.name');

        // dd($canceled);
        $completedChartData = $completed->map(function ($woList, $productName) {
            return [
                'name' => $productName,
                'data' => $woList->count()
            ];
        })->values();

        $inProgressChartData = $inProgress->map(function ($woList, $productName) {
            return [
                'name' => $productName,
                'data' => $woList->count()
            ];
        })->values();

        $canceledChartData = $canceled->map(function ($woList, $productName) {
            return [
                'name' => $productName,
                'data' => $woList->count()
            ];
        })->values();
// dd($completed);
        return view('admin.home', [
            'title' => 'Dashboard',
            'jumlah_user' => $jumlah_user,
            'total_plan_wo' => $total_plan_wo,
            'total_wo_in_progress' => $total_wo_in_progress,
            'total_wo_completed' => $total_wo_completed,
            'total_wo_canceled' => $total_wo_canceled,
            'yearly' => $yearly,
            'monthly' => $monthly,
            'weekly' => $weekly,
            'completed' => $completed,
            'inProgress' => $inProgress,
            'canceled' => $canceled,
            'completedChartData' => $completedChartData,
            'inProgressChartData' => $inProgressChartData,
            'canceledChartData' => $canceledChartData,

        ]);
    }
}
