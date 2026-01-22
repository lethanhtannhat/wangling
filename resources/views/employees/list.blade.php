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
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">
                        No users found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
