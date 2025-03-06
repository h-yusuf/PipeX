@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('theme/css/datatables.min.css') }}">
<style>
    .btn-custom {
        font-size: 2vh !important;
        font-weight: 900;
    }

    .btn-custom.active {
        border: 3px solid #000;
        opacity: 0.9;
        color: #000 !important;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">

            <div id="alert-box" style="display: none;" class="alert"></div>

            <div class="card-header btn-group mb-4">
                <button class="btn btn-lg btn-warning p-5 filter-btn btn-custom" data-status="Pending">
                    <i class="fas fa-calendar-alt mr-2"></i> Planning
                </button>
                <button class="btn btn-lg btn-success p-5 text-white filter-btn btn-custom " data-status="In Progress">
                    <i class="fas fa-play-circle mr-2"></i> In Progress
                </button>
                <button class="btn btn-lg btn-primary p-5 text-white filter-btn btn-custom " data-status="Completed">
                    <i class="fas fa-check-circle mr-2"></i> Finish
                </button>
                <button class="btn btn-lg btn-danger p-5 btn-custom">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Downtime
                </button>
            </div>


            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="workOrderTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Work Order Number</th>
                                <th>Product</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="optional-column">Qty Progress</th>
                                <th>Qty Target</th>
                                <th class="optional-column">Start Production</th>
                                <th class="optional-column">End Production</th>
                                <th class="optional-column">Progress</th>
                                <th class="w-5">Actions</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="updateStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Update Work Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="work_order_id">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    @include('pages.operator.js')
@endsection
@stop