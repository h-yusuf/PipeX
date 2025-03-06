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
                        let actionButton = '';

                        if (workOrder.status === 'Completed') {
                            actionButton = '-';
                        } else if (workOrder.status === 'In Progress') {
                            if (workOrder.qty_progress == workOrder.quantity) {
                                actionButton = `<button class="btn btn-sm btn-success complete-btn"
                                    data-id="${workOrder.id}">
                                    <i class="fas fa-check"></i> Complete
                                </button>`;
                            } else {
                                actionButton = `
                                            <div class="d-flex flex-column gap-1">
                                                <div>
                                                    <small class="text-muted">Deskripsi Progress</small>
                                                    <input 
                                                        type="text"  
                                                        class="form-control form-control-sm deskripsi-progress-input " 
                                                        data-id="${workOrder.id}" 
                                                        placeholder="Contoh: Pemotongan selesai"
                                                        value="">
                                                </div>
                                                <div>
                                                    <small class="text-muted">Qty Progress</small>
                                                    <input 
                                                        type="number" 
                                                        min="0" 
                                                        max="${workOrder.quantity}" 
                                                        class="form-control form-control-sm qty-progress-input" 
                                                        data-id="${workOrder.id}" 
                                                        value="${workOrder.qty_progress ?? 0}">
                                                    <small class="text-muted">Max: ${workOrder.quantity}</small>
                                                </div>
                                            </div>
                                        `;
                            }
                        } else {
                            actionButton = `<button class="btn btn-sm btn-primary update-status-btn" 
                                data-id="${workOrder.id}" data-status="${workOrder.status}" 
                                data-toggle="modal" data-target="#updateStatusModal">
                                Update Status
                            </button>`;
                        }

                        const lastProgress = workOrder.progress_logs.length
                            ? workOrder.progress_logs[workOrder.progress_logs.length - 1].description
                            : '-';

                        data.push([
                            index + 1,
                            workOrder.work_order_number,
                            workOrder.product ? workOrder.product.product_name : '-',
                            workOrder.due_date,
                            workOrder.status,
                            workOrder.qty_progress ?? '-',
                            workOrder.quantity,
                            workOrder.start_production ?? '-',
                            workOrder.finish_production ?? '-',
                            lastProgress,
                            actionButton
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
                                { title: "Due Date" },
                                { title: "Status" },
                                { title: "Qty Progress", className: "optional-column" },
                                { title: "Qty Target" },
                                { title: "Start Production", className: "optional-column" },
                                { title: "End Production", className: "optional-column" },
                                { title: "Progress", className: "optional-column" },
                                { title: "Actions" },
                            ]
                        });
                    }

                    if (['In Progress', 'Completed'].includes(status)) {
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
            currentStatus = status;
            setActiveButton(status);
            loadWorkOrders(status);
        });

        $(document).on('click', '.update-status-btn', function () {
            $('#work_order_id').val($(this).data('id'));
            $('#status').val($(this).data('status'));
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
                    $('.modal-backdrop').remove();
                    loadWorkOrders(currentStatus);
                    setActiveButton(currentStatus);
                },
                error: function (xhr) {
                    let errorMsg = xhr.responseJSON?.error || 'Failed to update status';
                    showAlert(errorMsg, 'danger');
                }
            });
        });

        $(document).on('change', '.deskripsi-progress-input', function () {
            const id = $(this).data('id');
            const deskripsi = $(this).val();

            $.ajax({
                url: `/api-workorder/${id}/progress`,
                method: 'PUT',
                data: { deskripsi },
                success: function () {
                    showAlert('Progress berhasil disimpan', 'success');
                    loadWorkOrders(currentStatus);
                    setActiveButton(currentStatus);
                },
                error: function () {
                    showAlert('Gagal menyimpan progress', 'danger');
                }
            });
        });

        $(document).on('change', '.qty-progress-input', function () {
            const id = $(this).data('id');
            const qty_progress = $(this).val();

            $.ajax({
                url: `/api-workorder/${id}/update-qty`,
                method: 'PUT',
                data: { qty_progress },
                success: function () {
                    showAlert('Qty Progress updated', 'success');
                    loadWorkOrders(currentStatus);
                    setActiveButton(currentStatus);
                },
                error: function () {
                    showAlert('Failed to update Qty Progress', 'danger');
                }
            });
        });

        $(document).on('click', '.complete-btn', function () {
            const id = $(this).data('id');

            $.ajax({
                url: `/api-workorder/${id}/update`,
                method: 'PUT',
                data: { status: 'Completed' },
                success: function () {
                    showAlert('Work Order marked as Completed', 'success');
                    loadWorkOrders(currentStatus);
                },
                error: function () {
                    showAlert('Failed to complete Work Order', 'danger');
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