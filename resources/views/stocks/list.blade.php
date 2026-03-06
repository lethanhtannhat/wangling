@extends('layouts.app')

@section('title', 'Stock List')
@section('header', 'Stock List')

@section('content')
<div class="section">
    <div class="section-header">Stock List</div>
    <div class="section-body">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        @php
                            $headerStyle = "white-space: nowrap; padding: 10px 15px; font-weight: 600; vertical-align: middle;";
                        @endphp
                        @if(config('features.stock_sort'))
                            <th style="{{ $headerStyle }}"><x-sort-link col="name" label="Name" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="department" label="Department" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="asset_id" label="Laptop Asset ID" /></th>
                            <th style="{{ $headerStyle }}" class="column-gray"><x-sort-link col="os" label="Mac/Win" /></th>
                            <th style="{{ $headerStyle }}" class="column-gray"><x-sort-link col="device_model" label="Model" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="os_version" label="OS" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="encryption_status" label="FileVault/BitLocker" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="admin_password_status" label="Admin Pass" /></th>
                            <th style="{{ $headerStyle }}" class="column-tech"><x-sort-link col="speedometer_score" label="Speedometer" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="previous_user" label="Previous User" /></th>
                        @else
                            <th style="{{ $headerStyle }}">Name</th>
                            <th style="{{ $headerStyle }}">Department</th>
                            <th style="{{ $headerStyle }}">Laptop Asset ID</th>
                            <th style="{{ $headerStyle }}" class="column-gray">Mac/Win</th>
                            <th style="{{ $headerStyle }}" class="column-gray">Model</th>
                            <th style="{{ $headerStyle }}" class="column-tech">OS</th>
                            <th style="{{ $headerStyle }}" class="column-tech">Encryption</th>
                            <th style="{{ $headerStyle }}" class="column-tech">Admin Pass</th>
                            <th style="{{ $headerStyle }}" class="column-tech">Speedo</th>
                            <th style="{{ $headerStyle }}">Previous User</th>
                        @endif
                        @if(config('features.stock_edit') || config('features.stock_delete'))
                            <th style="{{ $headerStyle }}">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @php
                    $cellStyle = "white-space: nowrap; padding: 10px 15px; vertical-align: middle;";
                @endphp
                @forelse ($stocks as $stock)
                    <tr>
                        <td style="{{ $cellStyle }}">{{ $stock->name }}</td>
                        <td style="{{ $cellStyle }}">{{ $stock->department }}</td>
                        <td style="{{ $cellStyle }}">{{ $stock->asset_id }}</td>
                        <td style="{{ $cellStyle }}" class="column-gray">
                            <span class="os-badge {{ strtolower($stock->asset->os ?? 'unknown') }}">{{ $stock->asset->os ?? 'Unknown' }}</span>
                        </td>
                        <td style="{{ $cellStyle }}" class="column-gray">{{ $stock->asset->device_model ?? 'N/A' }}</td>
                        <td style="{{ $cellStyle }}" class="column-tech">{{ $stock->os_version ?? '-' }}</td>
                        <td style="{{ $cellStyle }}" class="column-tech text-center">
                            @if(($stock->encryption_status ?? '') == 'On')
                                <span class="badge bg-success">On</span>
                            @elseif(($stock->encryption_status ?? '') == 'Off')
                                <span class="badge bg-danger">Off</span>
                            @else
                                {{ $stock->encryption_status ?? '-' }}
                            @endif
                        </td>
                        <td style="{{ $cellStyle }}" class="column-tech text-center">
                            @if(($stock->admin_password_status ?? '') == 'Ok')
                                <span class="badge bg-success">Ok</span>
                            @elseif(($stock->admin_password_status ?? '') == 'Not yet')
                                <span class="badge bg-warning text-dark">Not yet</span>
                            @else
                                {{ $stock->admin_password_status ?? '-' }}
                            @endif
                        </td>
                        <td style="{{ $cellStyle }}" class="column-tech">{{ $stock->speedometer_score ?? '-' }}</td>
                        <td style="{{ $cellStyle }}">{{ $stock->previous_user ?? '-' }}</td>
                        <td style="{{ $cellStyle }}">
                            <div class="d-flex gap-1">
                                @if(config('features.stock_edit'))
                                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                @endif
                                @if(config('features.stock_delete'))
                                    <button class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                            data-action-url="{{ route('stocks.destroy', $stock->id) }}" 
                                            data-display-name="{{ $stock->name }}">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="12" class="text-center py-3">No stock items found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-delete-modal id="deleteModal" title="Delete Stock Item" message="Are you sure you want to delete this stock item?" />
@endsection
