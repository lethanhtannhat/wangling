@extends('layouts.app')

@php
    $isEdit = isset($asset) && $asset->exists;
    $title = $isEdit ? 'Edit Asset' : 'Create Asset';
    $action = $isEdit ? route('assets.update', $asset->id) : route('assets.store');
    $buttonText = $isEdit ? 'Update' : 'Create';
@endphp

@section('title', $title)
@section('header', $title)

@section('content')
<div class="section">
    <div class="section-body">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <table>
                <tr>
                    <td class="label-col">Asset ID</td>
                    <td class="input-col"><input type="text" name="asset_id" id="asset_id" value="{{ old('asset_id', $asset->asset_id) }}" required></td>
                    <td class="label-col">Mac or Win</td>
                    <td class="input-col">
                        <select name="os" required>
                            <option value="">-- Select --</option>
                            <option value="Win" {{ old('os', $asset->os) == 'Win' ? 'selected' : '' }}>Win</option>
                            <option value="Mac" {{ old('os', $asset->os) == 'Mac' ? 'selected' : '' }}>Mac</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Device Model</td>
                    <td class="input-col"><input type="text" name="device_model" value="{{ old('device_model', $asset->device_model) }}" required></td>
                    <td class="label-col">Chip</td>
                    <td class="input-col"><input type="text" name="chip" value="{{ old('chip', $asset->chip) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Memory (GB)</td>
                    <td class="input-col"><input type="number" name="memory" min="0" value="{{ old('memory', $asset->memory) }}" required></td>
                    <td class="label-col">Storage (GB)</td>
                    <td class="input-col"><input type="number" name="storage" min="0" value="{{ old('storage', $asset->storage) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Serial Number</td>
                    <td class="input-col"><input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" required></td>
                    <td class="label-col">Release Year</td>
                    <td class="input-col"><input type="number" name="release_year" min="1900" max="{{ date('Y') + 10 }}" value="{{ old('release_year', $asset->release_year) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Purchase Date</td>
                    <td class="input-col"><input type="text" name="purchase_date" id="purchaseDate" placeholder="yyyy-mm-dd" value="{{ old('purchase_date', $asset->purchase_date) }}" required></td>
                    <td class="label-col">Note</td>
                    <td class="input-col"><textarea name="notes" class="auto-expand">{{ old('notes', $asset->notes) }}</textarea></td>
                </tr>
            </table>

            <button type="submit" class="btn-submit mt-3">{{ $buttonText }}</button>
            <x-form-errors />
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    $("#purchaseDate").datepicker({ format: "yyyy-mm-dd", todayHighlight: true, autoclose: true });

    const currentId = "{{ $asset->id ?? '' }}";
    const checkUrl = "{{ route('assets.check-unique') }}";
    
    setupRealtimeValidation({ inputSelector: '#asset_id', checkUrl, fieldName: 'asset_id', label: 'Asset ID', currentId });
    setupRealtimeValidation({ inputSelector: '#serial_number', checkUrl, fieldName: 'serial_number', label: 'Serial Number', currentId });
});
</script>
@endsection
