@extends('layouts.app')

@section('title', 'Asset List')
@section('header', 'Asset List')

@section('content')
@if(config('features.asset_filter'))
    @include('assets.partials.filter')
@endif

<div class="section">
    <div class="section-header">Asset List</div>
    <div class="section-body p-0">
        <div class="table-responsive" style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 4px;">
            <table class="table mb-0" style="width: auto; min-width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        @php
                            $headerStyle = "white-space: nowrap; padding: 10px 15px; background: #f8f9fa;";
                        @endphp
                        @if(config('features.asset_sort'))
                            <th style="{{ $headerStyle }}"><x-sort-link col="asset_id" label="Asset ID" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="os" label="Mac or Win" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="device_model" label="Device Model" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="serial_number" label="Serial Number" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="chip" label="Chip" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="memory" label="Memory" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="storage" label="Storage" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="release_year" label="Release Year" /></th>
                            <th style="{{ $headerStyle }}"><x-sort-link col="purchase_date" label="Purchase Date" /></th>
                        @else
                            <th style="{{ $headerStyle }}">Asset ID</th><th style="{{ $headerStyle }}">Mac/Win</th><th style="{{ $headerStyle }}">Model</th><th style="{{ $headerStyle }}">Serial</th><th style="{{ $headerStyle }}">Chip</th><th style="{{ $headerStyle }}">Mem</th><th style="{{ $headerStyle }}">Disk</th><th style="{{ $headerStyle }}">Release Year</th><th style="{{ $headerStyle }}">Purchase Date</th>
                        @endif
                        @if(config('features.asset_edit') || config('features.asset_delete'))
                            <th style="{{ $headerStyle }}">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @php
                    $cellStyle = "white-space: nowrap; padding: 10px 15px; vertical-align: middle;";
                @endphp
                @forelse ($assets as $asset)
                    <tr>
                        <td style="{{ $cellStyle }}">{{ $asset->asset_id }}</td>
                        <td style="{{ $cellStyle }}" class="text-center"><span class="os-badge {{ strtolower($asset->os) }}">{{ $asset->os }}</span></td>
                        <td style="{{ $cellStyle }}">{{ $asset->device_model }}</td>
                        <td style="{{ $cellStyle }}">{{ $asset->serial_number }}</td>
                        <td style="{{ $cellStyle }}">{{ $asset->chip }}</td>
                        <td style="{{ $cellStyle }}">{{ $asset->memory }} GB</td>
                        <td style="{{ $cellStyle }}">{{ $asset->storage }} GB</td>
                        <td style="{{ $cellStyle }}">{{ $asset->release_year }}</td>
                        <td style="{{ $cellStyle }}">{{ \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') }}</td>
                        <td style="{{ $cellStyle }}">
                            <div class="d-flex gap-1">
                                @if(config('features.asset_edit'))
                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                @endif
                                @if(config('features.asset_delete'))
                                    <button class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                            data-action-url="{{ route('assets.destroy', $asset->id) }}" 
                                            data-display-name="{{ $asset->asset_id }}">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center py-3">No assets found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-delete-modal id="deleteModal" title="Delete Asset" message="Are you sure you want to delete asset" />
@endsection

@section('scripts')
<script>
$(function () {
    $("#fromDate, #toDate").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true });
});
</script>
@endsection
