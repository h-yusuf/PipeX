@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('theme/css/datatables.min.css') }}">
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">

            <div class="card-header">
                <h5>Work Order Management</h5>
                <span class="d-block m-t-5">Manage work orders, including adding, editing, and tracking production
                    status.</span>
                <button id="addWorkOrderButton" class="btn btn-info float-left mt-2" data-toggle="modal"
                    data-target="#workOrderModal">Add Work Order</button>
                <form method="GET" action="{{ route('admin.workorder') }}" class="form-inline float-right form-ajax">
                    <select name="status" class="form-control mr-2">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In
                            Progress</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="Canceled" {{ request('status') == 'Canceled' ? 'selected' : '' }}>Canceled
                        </option>
                    </select>

                    <input type="date" name="start_date" class="form-control mr-2" value="{{ request('start_date') }}">
                    <input type="date" name="end_date" class="form-control mr-2" value="{{ request('end_date') }}">

                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.workorder') }}" class="btn btn-secondary ml-2">Reset</a>
                </form>
            </div>

        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table id="workOrderTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Work Order Number</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Operator</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal for Create -->
<div class="modal fade" id="workOrderModal" tabindex="-1" aria-labelledby="workOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Work Order</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="workOrderForm" class="form-ajax">
                    @csrf

                    <label>Product</label>
                    <select id="product_id" name="product_id" class="form-control" required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>

                    <label>Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required>

                    <label>Due Date</label>
                    <input type="date" id="due_date" name="due_date" class="form-control" required>

                    <label>Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Canceled">Canceled</option>
                    </select>

                    <label>Operator</label>
                    <select id="operator_id" name="operator_id" class="form-control" required>
                        @foreach ($operators as $operator)
                            <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Update -->
<div class="modal fade" id="updateWorkOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Work Order</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="updateWorkOrderForm" method="POST" class="form-ajax">
                    @csrf
                    @method('PUT')

                    <label>operator</label>
                    <select id="operator_id" name="operator_id" class="form-control" required>
                        @foreach ($operators as $operator)
                            <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                        @endforeach
                    </select>
                    <label>Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Canceled">Canceled</option>
                    </select>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @include('pages.woManagement.js')
@endsection
@stop