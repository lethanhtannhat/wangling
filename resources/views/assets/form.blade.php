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
                    <td class="label-col">OS (Version)</td>
                    <td class="input-col"><input type="text" name="os_version" value="{{ old('os_version', $asset->os_version) }}" placeholder="e.g. Windows 10 version 22H2" required></td>
                    <td class="label-col">Device Model</td>
                    <td class="input-col"><input type="text" name="device_model" value="{{ old('device_model', $asset->device_model) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">FileVault / BitLocker</td>
                    <td class="input-col">
                        <select name="encryption_status" required>
                            <option value="">-- Select --</option>
                            <option value="On" {{ old('encryption_status', $asset->encryption_status) == 'On' ? 'selected' : '' }}>On</option>
                            <option value="Off" {{ old('encryption_status', $asset->encryption_status) == 'Off' ? 'selected' : '' }}>Off</option>
                        </select>
                    </td>
                    <td class="label-col">User type</td>
                    <td class="input-col">
                        <select name="user_type" required>
                            <option value="">-- Select --</option>
                            <option value="Standard" {{ old('user_type', $asset->user_type) == 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Admin" {{ old('user_type', $asset->user_type) == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Admin password status</td>
                    <td class="input-col">
                        <select name="admin_password_status" required>
                            <option value="">-- Select --</option>
                            <option value="Ok" {{ old('admin_password_status', $asset->admin_password_status) == 'Ok' ? 'selected' : '' }}>Ok</option>
                            <option value="Not yet" {{ old('admin_password_status', $asset->admin_password_status) == 'Not yet' ? 'selected' : '' }}>Not yet</option>
                        </select>
                    </td>
                    <td class="label-col">Apple ID / MS Account</td>
                    <td class="input-col">
                        <select name="account_status">
                            <option value="">-- Select --</option>
                            <option value="Sign in" {{ old('account_status', $asset->account_status) == 'Sign in' ? 'selected' : '' }}>Sign in</option>
                            <option value="Sign out" {{ old('account_status', $asset->account_status) == 'Sign out' ? 'selected' : '' }}>Sign out</option>
                            <option value="Riki approved" {{ old('account_status', $asset->account_status) == 'Riki approved' ? 'selected' : '' }}>Riki approved</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Speedometer 3.1</td>
                    <td class="input-col"><input type="number" name="speedometer_score" step="0.1" value="{{ old('speedometer_score', $asset->speedometer_score) }}"></td>
                    <td class="label-col">Novabench Score</td>
                    <td class="input-col"><input type="number" name="novabench_score" step="1" value="{{ old('novabench_score', $asset->novabench_score) }}"></td>
                </tr>
                <tr>
                    <td class="label-col">Chip</td>
                    <td class="input-col"><input type="text" name="chip" value="{{ old('chip', $asset->chip) }}" required></td>
                    <td class="label-col">Memory (GB)</td>
                    <td class="input-col"><input type="number" name="memory" min="0" value="{{ old('memory', $asset->memory) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Storage (GB)</td>
                    <td class="input-col"><input type="number" name="storage" min="0" value="{{ old('storage', $asset->storage) }}" required></td>
                    <td class="label-col">Serial Number</td>
                    <td class="input-col"><input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Release Year</td>
                    <td class="input-col"><input type="number" name="release_year" min="1900" max="{{ date('Y') + 10 }}" value="{{ old('release_year', $asset->release_year) }}" required></td>
                    <td class="label-col">Purchase Date</td>
                    <td class="input-col"><input type="text" name="purchase_date" id="purchaseDate" placeholder="yyyy-mm-dd" value="{{ old('purchase_date', $asset->purchase_date) }}" required></td>
                </tr>
                @if($isEdit)
                <tr>
                    <td class="label-col">Note</td>
                    <td class="input-col" colspan="3"><textarea name="notes" rows="3">{{ old('notes', $asset->notes) }}</textarea></td>
                </tr>
                @endif
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
