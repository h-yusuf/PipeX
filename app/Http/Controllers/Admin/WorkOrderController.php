<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\User;
use App\Models\WoManagementModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('wo_management'), Response::HTTP_FORBIDDEN, 'Forbidden');

        if ($request->ajax()) {
            $query = WoManagementModel::with(['product', 'operator']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('due_date', [$request->start_date, $request->end_date]);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('product', function ($row) {
                    return $row->product->product_number . ' - ' . $row->product->product_name;
                })
                ->addColumn('operator', function ($row) {
                    return $row->operator ? $row->operator->name . ' - ' . $row->operator->username : '-';
                })
                
                ->addColumn('progress', function ($row) {
                    $latestProgress = $row->progressLogs->last(); 
                    $description = $latestProgress ? $latestProgress->description : '-';
                
                    return '
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-truncate">' . $description . '</span>
                            <button type="button" class="btn btn-sm btn-secondary btn-show-progress ml-2" 
                                data-toggle="modal" 
                                data-target="#showProgressModal" 
                                data-id="' . $row->id . '">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    ';
                })                     
                ->addColumn('status', function ($row) {
                    switch ($row->status) {
                        case 'Completed':
                            $badgeClass = 'badge-success'; // Hijau
                            break;
                        case 'Canceled':
                            $badgeClass = 'badge-danger'; // Merah
                            break;
                        case 'Pending':
                            $badgeClass = 'badge-warning'; // Kuning
                            break;
                        case 'In Progress':
                            $badgeClass = 'badge-info'; // Biru
                            break;
                        default:
                            $badgeClass = 'badge-secondary'; // Abu-abu untuk status lain
                    }
                
                    return '<span class="badge badge-custom ' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                
                ->addColumn('actions', function ($row) {
                    if ($row->status !== 'Completed') {
                        $editBtn = '<button class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '" data-toggle="modal" data-target="#updateWorkOrderModal"><i class="fas fa-edit"></i></button>';
                        $deleteBtn = '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>';
                        return $editBtn . ' ' . $deleteBtn;
                    } else {
                        return '<span class="text-muted">No Action</span>';
                    }
                })                
                ->rawColumns(['status', 'actions', 'progress'])
                ->make(true);
        }

        $products = ProductModel::all();
        $operators = User::where('role_id', 3)->get();

        return view('pages.woManagement.index', compact('products', 'operators'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'due_date' => 'required|date',
                'status' => 'required|in:Pending,In Progress,Completed,Canceled',
                'operator_id' => 'required|exists:users,id',
            ]);

            $workOrderNumber = 'WO-' . now()->format('Ymd') . '-' . str_pad(WoManagementModel::count() + 1, 3, '0', STR_PAD_LEFT);

            $workOrder = WoManagementModel::create([
                'work_order_number' => $workOrderNumber,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'operator_id' => $request->operator_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Order added successfully!',
                'data' => $workOrder
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add Work Order: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'operator_id' => 'required|exists:users,id',
                'status' => 'required|in:Pending,In Progress,Completed,Canceled',
            ]);

            $workOrder = WoManagementModel::findOrFail($id);

            $workOrder->update([
                'operator_id' => $request->operator_id,
                'status' => $request->status,
            ]);

            return response()->json(['success' => 'Work Order updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Work Order: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $workOrder = WoManagementModel::with(['product', 'operator'])->findOrFail($id);
        return response()->json($workOrder);
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('wo_management'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $workOrder = WoManagementModel::findOrFail($id);
        $workOrder->delete();

        return response()->json(['success' => 'Work Order deleted successfully.']);
    }

    public function operatorIndex()
    {
        abort_if(Gate::denies('operator_management'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $data = ProductModel::orderBy('updated_at', 'desc')->get();
        return view('pages.operator.index', compact('data'));
    }
    public function reportManagement()
    {
        abort_if(Gate::denies('wo_management'), Response::HTTP_FORBIDDEN, 'Forbidden');

        return view('pages.report.index');
    }
}
