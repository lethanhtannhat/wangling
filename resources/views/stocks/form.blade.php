@extends('layouts.app')

@php
    $isEdit = isset($stock) && $stock->exists;
    $title = $isEdit ? 'Edit Stock' : 'Create Stock';
    $action = $isEdit ? route('stocks.update', $stock->id) : route('stocks.store');
    $buttonText = $isEdit ? 'Update' : 'Create';
@endphp

@section('title', $title)
@section('header', $title)

@section('content')
<div class="section">
    <div class="section-body">
        <form method="POST" action="{{ $action }}" id="stockForm">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <table>
                <tr>
                    <td class="label-col">Name</td>
                    <td class="input-col"><input type="text" name="name" value="{{ old('name', $stock->name) }}"></td>
                    <td class="label-col">Department</td>
                    <td class="input-col"><input type="text" name="department" value="{{ old('department', $stock->department) }}"></td>
                </tr>
                <tr>
                    <td class="label-col">Laptop Asset ID</td>
                    <td class="input-col">
                        <select name="asset_id" id="asset_id" class="form-control" required>
                            <option value="">-- Select Asset ID --</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->asset_id }}" 
                                    {{ old('asset_id', $stock->asset_id) == $asset->asset_id ? 'selected' : '' }}>
                                    {{ $asset->asset_id }} ({{ $asset->device_model }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="label-col">OS Version</td>
                    <td class="input-col">
                        <input type="text" name="os_version" value="{{ old('os_version', $stock->os_version) }}">
                    </td>
                </tr>
                <tr>
                    <td class="label-col">FileVault / BitLocker</td>
                    <td class="input-col">
                        <select name="encryption_status">
                            <option value="">-- Select --</option>
                            <option value="On" {{ old('encryption_status', $stock->encryption_status) == 'On' ? 'selected' : '' }}>On</option>
                            <option value="Off" {{ old('encryption_status', $stock->encryption_status) == 'Off' ? 'selected' : '' }}>Off</option>
                        </select>
                    </td>
                    <td class="label-col">Admin password status</td>
                    <td class="input-col">
                        <select name="admin_password_status">
                            <option value="">-- Select --</option>
                            <option value="Ok" {{ old('admin_password_status', $stock->admin_password_status) == 'Ok' ? 'selected' : '' }}>Ok</option>
                            <option value="Not yet" {{ old('admin_password_status', $stock->admin_password_status) == 'Not yet' ? 'selected' : '' }}>Not yet</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Speedometer 3.1</td>
                    <td class="input-col"><input type="number" name="speedometer_score" step="0.1" value="{{ old('speedometer_score', $stock->speedometer_score) }}"></td>
                    <td class="label-col">Previous User</td>
                    <td class="input-col">
                        <input type="text" name="previous_user" value="{{ old('previous_user', $stock->previous_user) }}">
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Note</td>
                    <td class="input-col"><input type="text" name="notes" value="{{ old('notes', $stock->notes) }}"></td>
                    <td class="label-col"></td><td class="input-col"></td>
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
    const currentId = "{{ $stock->id ?? '' }}";
    setupRealtimeValidation({
        inputSelector: '#asset_id',
        checkUrl: "{{ route('stocks.check-unique') }}",
        fieldName: 'asset_id',
        label: 'Laptop Asset ID',
        currentId: currentId
    });
});
</script>
@endsection
