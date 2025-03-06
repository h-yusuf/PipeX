@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('theme/css/datatables.min.css') }}">
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">

        {{-- Work Order Recap --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5>Work Order Recap</h5>
                <span class="d-block mt-2">Total statuses per product.</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="rekapTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Total Pending</th>
                                <th>Total In Progress</th>
                                <th>Total Completed</th>
                                <th>Total Canceled</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Operator Performance Report --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5>Operator Performance Report</h5>
                <span class="d-block mt-2">Total products successfully completed by operators.</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table id="operatorResultTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Operator Name</th>
                                <th>Product Name</th>
                                <th>Total Completed</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@section('scripts')
    @include('pages.report.js')
@endsection
@stop
