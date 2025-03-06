<script>
    $(document).ready(function () {
        var table = $('#workOrderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.workorder') }}",
                data: function (d) {
                    d.status = $('select[name="status"]').val();
                    d.start_date = $('input[name="start_date"]').val();
                    d.end_date = $('input[name="end_date"]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'work_order_number', name: 'work_order_number' },
                { data: 'product', name: 'product.product_name' },
                { data: 'quantity', name: 'quantity' },
                { data: 'due_date', name: 'due_date' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'operator', name: 'operator.name' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Reload table filter cuyy
        $('.form-ajax').on('submit', function (e) {
            e.preventDefault();
            table.ajax.reload();
        });

    });

    $(document).ready(function () {
        $('#workOrderForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.workorder.store') }}",
                method: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#workOrderForm')[0].reset(); // Reset form
                            $('#workOrderModal').modal('hide'); // Close modal
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'An error occurred.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).map(item => item[0]).join('\n');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error!',
                        text: errorMessage
                    });
                }
            });
        });
    });

    $('#workOrderModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $(document).on('show.bs.modal', '#updateWorkOrderModal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        console.log("Update Action URL: ", "{{ route('admin.workorder.update', ':id') }}".replace(':id', id));

        $.get("{{ route('admin.workorder.edit', ':id') }}".replace(':id', id), function (data) {
            console.log(data);
            
            $('#updateWorkOrderModal #operator_id').val(data.operator_id);
            $('#updateWorkOrderModal #status').val(data.status);

            $('#updateWorkOrderForm').attr('action', "{{ route('admin.workorder.update', ':id') }}".replace(':id', id));
        });
    });
    $('#updateWorkOrderForm').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#updateWorkOrderModal').modal('hide');
                $('#updateWorkOrderModal').on('hidden.bs.modal', function () {
                    $('.modal-backdrop').remove();
                    $('#workOrderTable').DataTable().ajax.reload();
                    Swal.fire('Success', response.success, 'success');
                });
            },
            error: function (xhr) {
                Swal.fire('Error', xhr.responseJSON.error, 'error');
            }
        });
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This work order will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.workorder.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#workOrderTable').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Work order has been deleted.',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#row-' + id).fadeOut(500, function () {
                            $(this).remove();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Failed to delete work order.'
                        });
                    }
                });
            }
        });
    });


</script>