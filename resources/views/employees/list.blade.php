@extends('layouts.app')

@section('title', 'User List')
@section('header', 'User List')

@section('content')
<div class="section">
    <div class="section-header">User List</div>
    <div class="section-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Team</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Laptop Asset ID</th>
                    <th>Mac or Win</th>
                    <th>Device Model</th>
                    @if(config('features.user_edit') || config('features.user_delete'))
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->team }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->asset_id }}</td>
                    <td>
                        @if($employee->asset)
                            <span class="os-badge {{ strtolower($employee->asset->os) }}">
                                {{ $employee->asset->os }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $employee->asset->device_model ?? '-' }}</td>
                    @if(config('features.user_edit') || config('features.user_delete'))
                    <td>
                        <div class="d-flex gap-1">
                            @if(config('features.user_edit'))
                            <a href="{{ route('users.edit', $employee->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            @endif

                            @if(config('features.user_delete'))
                            <button class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteUserModal" 
                                    data-id="{{ $employee->id }}" 
                                    data-name="{{ $employee->name }}">
                                Delete
                            </button>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ (config('features.user_edit') || config('features.user_delete')) ? 9 : 7 }}" class="text-center text-muted py-3">
                        No users found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(config('features.user_delete'))
<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    Are you sure you want to delete user <strong id="delete-user-name"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
$(function () {
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const name = button.data('name');
        
        $('#deleteUserForm').attr('action', '/users/' + id);
        $('#delete-user-name').text(name);
    });
});
</script>
@endsection
