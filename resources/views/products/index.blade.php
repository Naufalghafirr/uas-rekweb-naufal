@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <h5 class="mb-4">Data Produk</h5>
            <div class="card-body">
                <a href="{{ route('products.export') }}" class="btn btn-success mb-3">Export PDF</a>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah Produk</button>
                <table class="table table-bordered" id="productTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Developer</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="addProductForm">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>

                        <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg" style="display:none" onchange="previewImage(event)" required>
                        <div class="profile-pic-container" onclick="document.getElementById('image').click()">
                            <img src="https://via.placeholder.com/150" alt="Preview" id="preview" class="profile-pic">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" placeholder="Nama Produk" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" id="category" required class="form-control">
                            <option value="">Pilih Kategori</option>
                            <option value="Game">Game</option>
                            <option value="Aplikasi">Aplikasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control" placeholder="Harga" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="developer" class="form-label">Developer</label>
                        <input type="text" class="form-control" placeholder="Developer" id="developer" name="developer" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="editProductForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Gambar Produk</label>
                        <input type="file" id="edit_image" name="image" accept="image/png, image/jpeg, image/jpg" style="display:none" onchange="previewEditImage(event)" >
                        <div class="profile-pic-container" onclick="document.getElementById('edit_image').click()">
                            <img src="https://via.placeholder.com/150" alt="Preview" id="edit_preview" class="profile-pic edit-preview">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" placeholder="Nama Produk" id="edit_product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Kategori</label>
                        <select name="category" id="edit_category" required class="form-control">
                            <option value="">Pilih Kategori</option>
                            <option value="Game">Game</option>
                            <option value="Aplikasi">Aplikasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Harga</label>
                        <input type="number" class="form-control" placeholder="Harga" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_developer" class="form-label">Developer</label>
                        <input type="text" class="form-control" placeholder="Developer" id="edit_developer" name="developer" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewEditImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            document.getElementById('edit_preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    $('#addProductForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('products.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#addProductModal').modal('hide');
                $('#addProductForm')[0].reset();
                toastr.success('Produk berhasil ditambahkan');
                $('#productTable').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var actionUrl = $(this).attr('action');
        $.ajax({
            url: actionUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#editProductModal').modal('hide');
                toastr.success('Produk berhasil diupdate');
                $('#productTable').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                toastr.error('Gagal mengupdate produk');
            }
        });
    });

    $(document).ready(function() {
        $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'product_name', name: 'product_name'},
                {data: 'price', name: 'price'},
                {data: 'developer', name: 'developer'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    $(document).on('click', '#edit-product', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: "{{ route('products.get', ':id') }}".replace(':id', productId),
            type: "GET",
            success: function(response) {
                $('#editProductModal').modal('show');
                $('#editProductForm').attr('action', "{{ route('products.update', ':id') }}".replace(':id', productId));
                $('#editProductForm')[0].reset();
                $('#edit_product_name').val(response.product_name);
                $('#edit_price').val(response.price);
                $('#edit_developer').val(response.developer);
                $('#edit_category').val(response.category);
                $('#edit_preview').attr('src', "images/" + response.image);
            }
        });
    });

    $(document).on('click', '#delete-product', function() {
        var productId = $(this).data('id');
        var confirm = window.confirm('Apakah anda yakin ingin menghapus produk ini?');
        if (confirm) {
            $.ajax({
                url: "{{ route('products.destroy', ':id') }}".replace(':id', productId),
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success('Produk berhasil dihapus');
                    $('#productTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    if(xhr.status === 419) {
                        toastr.error('CSRF token mismatch.');
                    } else {
                        toastr.error('Gagal menghapus produk');
                    }
                }
            });
        }
    });
</script>
@endpush

<style>
.profile-pic-container {
    position: relative;
    width: 300px;
    height: 150px;
    margin: 0 auto 10px auto;
    cursor: pointer;
    background-color: #dcdcdc;
}
.profile-pic {
    width: 300px;
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
    border: 2px solid #f3f3f3;
}
.edit-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: rgba(59, 130, 246, 0.8);
    color: #fff;
    text-align: center;
    border-radius: 0 0 50% 50%;
    padding: 5px 0;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
}
</style>
