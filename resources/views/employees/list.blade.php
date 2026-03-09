@extends('layouts.app')

@section('title', 'User List')
@section('header', 'User List')

@section('content')
<div class="section">
    <div class="section-header">User List</div>
    <div class="section-body p-0">
        <div class="table-responsive" style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 4px;">
            <table class="table mb-0" style="width: auto; min-width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        @php
                            $headerStyle = "white-space: nowrap; padding: 10px 15px; background: #f8f9fa;";
                        @endphp
                        @if(config('features.user_sort'))
                            <th style="{{ $headerStyle }}"><x-sort-link col="department" label="Department" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="team" label="Team" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="name" label="Name" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="email" label="Email" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="asset_id" label="Asset ID" /></th>
                            <th style="{{ $headerStyle }}" class="column-gray"><x-sort-link col="os" label="Mac/Win" /></th>
                            <th style="{{ $headerStyle }}" class="column-gray"><x-sort-link col="device_model" label="Model" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="os_version" label="OS" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="encryption_status" label="FileVault/BitLocker" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="user_type" label="User Type" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="admin_password_status" label="Admin Pass" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="account_status" label="Apple ID/MS" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="speedometer_score" label="Speedometer" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="notes" label="Note" /></th>
                        @else
                            <th style="{{ $headerStyle }}">Dept</th><th style="{{ $headerStyle }}">Team</th><th style="{{ $headerStyle }}">Name</th><th style="{{ $headerStyle }}">Email</th><th style="{{ $headerStyle }}">Asset ID</th><th style="{{ $headerStyle }}" class="column-gray">Mac/Win</th><th style="{{ $headerStyle }}" class="column-gray">Model</th><th style="{{ $headerStyle }}" class="column-tech">OS</th><th style="{{ $headerStyle }}" class="column-tech">Encryption</th><th style="{{ $headerStyle }}" class="column-tech">User Type</th><th style="{{ $headerStyle }}" class="column-tech">Admin Pass</th><th style="{{ $headerStyle }}" class="column-tech">Account</th><th style="{{ $headerStyle }}" class="column-tech">Speedo</th><th style="{{ $headerStyle }}">Note</th>
                        @endif
                        @if(config('features.user_edit') || config('features.user_delete'))
                            <th style="{{ $headerStyle }}">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @php
                    $cellStyle = "white-space: nowrap; padding: 10px 15px; vertical-align: middle;";
                @endphp
                @forelse ($employees as $employee)
                    <tr>
                        <td style="{{ $cellStyle }}">{{ $employee->department }}</td>
                        <td style="{{ $cellStyle }}">{{ $employee->team }}</td>
                        <td style="{{ $cellStyle }}">{{ $employee->name }}</td>
                        <td style="{{ $cellStyle }}">{{ $employee->email }}</td>
                        <td style="{{ $cellStyle }}">{{ $employee->asset_id }}</td>
                        <td style="{{ $cellStyle }}" class="column-gray">
                            <span class="os-badge {{ strtolower($employee->asset->os ?? 'unknown') }}">{{ $employee->asset->os ?? 'Unknown' }}</span>
                        </td>
                        <td style="{{ $cellStyle }}" class="column-gray">{{ $employee->asset->device_model ?? 'Deleted Asset' }}</td>
                        <td style="{{ $cellStyle }}" class="column-tech">{{ $employee->os_version ?? '-' }}</td>
                        <td style="{{ $cellStyle }}" class="column-tech text-center">
                            @if(($employee->encryption_status ?? '') == 'On')
                                <span class="badge bg-success">On</span>
                            @elseif(($employee->encryption_status ?? '') == 'Off')
                                <span class="badge bg-danger">Off</span>
                            @else
                                {{ $employee->encryption_status ?? '-' }}
                            @endif
                        </td>
                        <td style="{{ $cellStyle }}" class="column-tech">{{ $employee->user_type ?? '-' }}</td>
                        <td style="{{ $cellStyle }}" class="column-tech text-center">
                            @if(($employee->admin_password_status ?? '') == 'Ok')
                                <span class="badge bg-success">Ok</span>
                            @elseif(($employee->admin_password_status ?? '') == 'Not yet')
                                <span class="badge bg-warning text-dark">Not yet</span>
                            @else
                                {{ $employee->admin_password_status ?? '-' }}
                            @endif
                        </td>
                        <td style="{{ $cellStyle }}" class="column-tech">{{ $employee->account_status ?? '-' }}</td>
                        <td style="{{ $cellStyle }}" class="column-tech">{{ $employee->speedometer_score ?? '-' }}</td>
                        <td style="{{ $cellStyle }}">{{ $employee->notes ?? '-' }}</td>
                        <td style="{{ $cellStyle }}">
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
                    <tr><td colspan="15" class="text-center py-3">No users found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-delete-modal id="deleteModal" title="Delete User" message="Are you sure you want to delete user" />
@endsection
