@extends('layouts.app')
@section('title', 'Data Users')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <h5 class="mb-4">Data Users</h5>
            <div class="card-body">
                <a href="{{ route('users.export-pdf') }}" class="btn btn-success mb-3">Export PDF</a>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah User</button>
                <table class="table table-bordered" id="userTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" placeholder="Nama" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" placeholder="Konfirmasi Password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div id="addUserErrors" class="alert alert-danger d-none"></div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" placeholder="Nama" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control" placeholder="Password" id="edit_password" name="password">
                    </div>
                    <div id="editUserErrors" class="alert alert-danger d-none"></div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showErrors(errors, selector) {
        let html = '<ul>';
        $.each(errors, function(key, value) {
            html += '<li>' + value + '</li>';
        });
        html += '</ul>';
        $(selector).removeClass('d-none').html(html);
    }
    function clearErrors(selector) {
        $(selector).addClass('d-none').html('');
    }
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        clearErrors('#addUserErrors');
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('users.store') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                $('#addUserModal').modal('hide');
                $('#addUserForm')[0].reset();
                toastr.success('User berhasil ditambahkan');
                $('#userTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    showErrors(xhr.responseJSON.errors, '#addUserErrors');
                } else {
                    toastr.error('Gagal menambah user');
                }
            }
        });
    });
    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        clearErrors('#editUserErrors');
        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');
        $.ajax({
            url: actionUrl,
            type: "POST",
            data: formData,
            headers: {
                'X-HTTP-Method-Override': 'PUT',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#editUserModal').modal('hide');
                toastr.success('User berhasil diupdate');
                $('#userTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    showErrors(xhr.responseJSON.errors, '#editUserErrors');
                } else {
                    toastr.error('Gagal mengupdate user');
                }
            }
        });
    });
    $(document).ready(function() {
        $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
    $(document).on('click', '#edit-user', function() {
        var userId = $(this).data('id');
        $.ajax({
            url: "{{ route('users.get', ':id') }}".replace(':id', userId),
            type: "GET",
            success: function(response) {
                $('#editUserModal').modal('show');
                $('#editUserForm').attr('action', "{{ route('users.update', ':id') }}".replace(':id', userId));
                $('#editUserForm')[0].reset();
                $('#edit_name').val(response.name);
                $('#edit_email').val(response.email);
            }
        });
    });
    $(document).on('click', '#delete-user', function() {
        var userId = $(this).data('id');
        if (confirm('Apakah anda yakin ingin menghapus user ini?')) {
            $.ajax({
                url: "{{ route('users.destroy', ':id') }}".replace(':id', userId),
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success('User berhasil dihapus');
                    $('#userTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Gagal menghapus user');
                }
            });
        }
    });
</script>
@endpush
