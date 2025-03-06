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
                                <th>Quantity</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="optional-column">Qty Progress</th>
                                <th class="optional-column">Start Production</th>
                                <th class="optional-column">End Production</th>
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
                            <option value="Completed">Completed</option>
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
    <script>
        $(document).ready(function () {
            let workOrderTable;
            let currentStatus = 'Pending';

            function initDataTable() {
                workOrderTable = $('#workOrderTable').DataTable({
                    destroy: true,
                });
            }


            function destroyDataTable() {
                if (workOrderTable) {
                    workOrderTable.destroy();
                }
            }

            function setActiveButton(status) {
                $('.filter-btn').removeClass('active');
                $(`.filter-btn[data-status="${status}"]`).addClass('active');
            }

            function loadWorkOrders(status = null) {
                $.ajax({
                    url: '/api-workorders',
                    method: 'GET',
                    data: { status: status },
                    success: function (response) {
                        let data = [];
                        $.each(response.data, function (index, workOrder) {
                            data.push([
                                index + 1,
                                workOrder.work_order_number,
                                workOrder.product ? workOrder.product.product_name : '-',
                                workOrder.quantity,
                                workOrder.due_date,
                                workOrder.status,
                                workOrder.qty_progress ?? '-',
                                workOrder.start_production ?? '-',
                                workOrder.end_production ?? '-',
                                `<button class="btn btn-sm btn-primary update-status-btn" 
                                data-id="${workOrder.id}" data-status="${workOrder.status}" 
                                data-toggle="modal" data-target="#updateStatusModal">
                                Update Status
                            </button>`
                            ]);
                        });

                        if (workOrderTable) {
                            workOrderTable.clear().rows.add(data).draw();
                        } else {
                            workOrderTable = $('#workOrderTable').DataTable({
                                data: data,
                                columns: [
                                    { title: "#" },
                                    { title: "Work Order Number" },
                                    { title: "Product" },
                                    { title: "Quantity" },
                                    { title: "Due Date" },
                                    { title: "Status" },
                                    { title: "Qty Progress", className: "optional-column" },
                                    { title: "Start Production", className: "optional-column" },
                                    { title: "End Production", className: "optional-column" },
                                    { title: "Actions" },
                                ]
                            });
                        }

                        if (status === 'In Progress') {
                            $('.optional-column').show();
                        } else {
                            $('.optional-column').hide();
                        }
                    },
                    error: function () {
                        showAlert('Failed to load data', 'danger');
                    }
                });
            }


            $(document).on('click', '.filter-btn', function () {
                const status = $(this).data('status');
                loadWorkOrders(status);
            });

            $(document).on('click', '.update-status-btn', function () {
                $('#work_order_id').val($(this).data('id'));
                $('#status').val($(this).data('status'));
            });

            $('#updateStatusForm').submit(function (e) {
                e.preventDefault();
                let id = $('#work_order_id').val();
                let status = $('#status').val();

                $.ajax({
                    url: `/api-workorder/${id}/update`,
                    method: 'PUT',
                    data: { status },
                    success: function () {
                        $('#updateStatusModal').modal('hide');
                        showAlert('Status updated successfully', 'success');
                        loadWorkOrders(currentStatus);
                    },
                    error: function (xhr) {
                        let errorMsg = xhr.responseJSON?.error || 'Failed to update status';
                        showAlert(errorMsg, 'danger');
                    }
                });
            });

            function showAlert(message, type) {
                $('#alert-box').removeClass('alert-success alert-danger').addClass(`alert-${type}`).text(message).fadeIn();
                setTimeout(() => { $('#alert-box').fadeOut(); }, 3000);
            }

            // Initial load
            loadWorkOrders('Pending');
        });

    </script>

    @stop
@endsection