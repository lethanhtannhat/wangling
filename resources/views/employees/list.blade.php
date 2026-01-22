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
                    <th>Department</th><th>Team</th><th>Name</th><th>Email</th><th>Asset ID</th><th>OS</th><th>Model</th>
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
                            <span class="os-badge {{ strtolower($employee->asset->os) }}">{{ $employee->asset->os }}</span>
                        @else - @endif
                    </td>
                    <td>{{ $employee->asset->device_model ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            @if(config('features.user_edit'))
                                <a href="{{ route('users.edit', $employee->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            @endif
                            @if(config('features.user_delete'))
                                <button class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                        data-action-url="{{ route('users.destroy', $employee->id) }}" 
                                        data-display-name="{{ $employee->name }}">Delete</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center py-3">No users found</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<x-delete-modal id="deleteModal" title="Delete User" message="Are you sure you want to delete user" />
@endsection
