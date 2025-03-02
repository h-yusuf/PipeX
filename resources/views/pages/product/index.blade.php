@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('theme/css/datatables.min.css') }}">
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">

            @if ($errors->any())
                <div id="alert-box" class="alert alert-danger">
                    <ul id="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div id="alert-box" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <div class="card-header">
                <h5>Product Management</h5>
                <span class="d-block m-t-5">Displays the history of checksheets from completed preventive maintenance
                    tasks, including inspection results and actions taken.</span>
                <button id="addProductButton" class="btn btn-info float-left mt-2" data-toggle="modal"
                    data-target="#productModal"">Add Product</button>
            </div>

            <div class=" card-body table-border-style">
                    <div class="table-responsive">
                        <table id="productTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Number</th>
                                    <th>Product Name</th>
                                    <th>Material</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->product_number }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->material }}</td>
                                        <td>{{ $product->unit }}</td>
                                        <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge badge-custom {{ $product->status ? 'badge-success' : 'badge-danger' }}">
                                                {{ $product->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $product->id }}"
                                                data-toggle="modal" data-target="#updateProductModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Create  -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.product.store') }}">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id">

                    <label>Product Name</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" required>

                    <label>Material</label>
                    <input type="text" id="material" name="material" class="form-control">

                    <label>Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>

                    <label>Unit</label>
                    <input type="text" id="unit" name="unit" class="form-control" required>

                    <label>Price</label>
                    <input type="number" id="price" name="price" class="form-control" required>

                    <label>Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Modal for update  -->
<div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="product_number">Product Number</label>
                        <input type="text" id="product_number" name="product_number" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="material">Material</label>
                        <input type="text" id="material" name="material" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <input type="text" id="unit" name="unit" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#productTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthMenu": [10, 25, 50, 100],
                "language": {
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next"
                    }
                }

            });
        });
        $(document).on('show.bs.modal', '#updateProductModal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            $.get("{{ route('admin.product.edit', ':id') }}".replace(':id', id), function (data) {
                $('#updateProductModal #product_number').val(data.product_number);
                $('#updateProductModal #product_name').val(data.product_name);
                $('#updateProductModal #material').val(data.material);
                $('#updateProductModal #description').val(data.description);
                $('#updateProductModal #unit').val(data.unit);
                $('#updateProductModal #price').val(data.price);
                $('#updateProductModal #status').val(data.status);

                $('#updateProductForm').attr('action', "{{ route('admin.product.update', ':id') }}".replace(':id', id));
            });
        });
    </script>
    @stop
@endsection