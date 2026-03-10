@extends('layouts.app')

@php
    $isEdit = isset($employee) && $employee->exists;
    $title = $isEdit ? 'Edit User' : 'Create User';
    $action = $isEdit ? route('users.update', $employee->id) : route('users.store');
    $buttonText = $isEdit ? 'Update' : 'Create';
@endphp

@section('title', $title)
@section('header', $title)

@section('content')
<div class="section">
    <div class="section-body">
        <form method="POST" action="{{ $action }}" id="userForm">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <table>
                <tr>
                    <td class="label-col">Department</td>
                    <td class="input-col"><input type="text" name="department" value="{{ old('department', $employee->department) }}" required></td>
                    <td class="label-col">Team</td>
                    <td class="input-col"><input type="text" name="team" value="{{ old('team', $employee->team) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Name</td>
                    <td class="input-col"><input type="text" name="name" value="{{ old('name', $employee->name) }}" required></td>
                    <td class="label-col">Email</td>
                    <td class="input-col"><input type="email" name="email" value="{{ old('email', $employee->email) }}" required></td>
                </tr>
                <tr>
                    <td class="label-col">Laptop Asset ID</td>
                    <td class="input-col">
                        <select name="asset_id" id="asset_id" class="form-control" required>
                            <option value="">-- Select Asset ID --</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->asset_id }}" 
                                    {{ old('asset_id', $employee->asset_id) == $asset->asset_id ? 'selected' : '' }}>
                                    {{ $asset->asset_id }} ({{ $asset->device_model }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="label-col">OS Version</td>
                    <td class="input-col">
                        <input type="text" name="os_version" value="{{ old('os_version', $employee->os_version) }}">
                    </td>
                </tr>
                <tr>
                    <td class="label-col">FileVault / BitLocker</td>
                    <td class="input-col">
                        <select name="encryption_status">
                            <option value="">-- Select --</option>
                            <option value="On" {{ old('encryption_status', $employee->encryption_status) == 'On' ? 'selected' : '' }}>On</option>
                            <option value="Off" {{ old('encryption_status', $employee->encryption_status) == 'Off' ? 'selected' : '' }}>Off</option>
                        </select>
                    </td>
                    <td class="label-col">User type</td>
                    <td class="input-col">
                        <select name="user_type">
                            <option value="">-- Select --</option>
                            <option value="Standard" {{ old('user_type', $employee->user_type) == 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Admin" {{ old('user_type', $employee->user_type) == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Admin password status</td>
                    <td class="input-col">
                        <select name="admin_password_status">
                            <option value="">-- Select --</option>
                            <option value="Ok" {{ old('admin_password_status', $employee->admin_password_status) == 'Ok' ? 'selected' : '' }}>Ok</option>
                            <option value="Not yet" {{ old('admin_password_status', $employee->admin_password_status) == 'Not yet' ? 'selected' : '' }}>Not yet</option>
                        </select>
                    </td>
                    <td class="label-col">Apple ID / MS Account</td>
                    <td class="input-col">
                        <select name="account_status">
                            <option value="">-- Select --</option>
                            <option value="Sign in" {{ old('account_status', $employee->account_status) == 'Sign in' ? 'selected' : '' }}>Sign in</option>
                            <option value="Sign out" {{ old('account_status', $employee->account_status) == 'Sign out' ? 'selected' : '' }}>Sign out</option>
                            <option value="Riki approved" {{ old('account_status', $employee->account_status) == 'Riki approved' ? 'selected' : '' }}>Riki approved</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Speedometer 3.1</td>
                    <td class="input-col"><input type="number" name="speedometer_score" step="0.1" value="{{ old('speedometer_score', $employee->speedometer_score) }}"></td>
                    <td class="label-col">Note</td>
                    <td class="input-col"><textarea name="notes" class="auto-expand">{{ old('notes', $employee->notes) }}</textarea></td>
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
    const currentId = "{{ $employee->id ?? '' }}";
    setupRealtimeValidation({
        inputSelector: '#asset_id',
        checkUrl: "{{ route('users.check-unique') }}",
        fieldName: 'asset_id',
        label: 'Laptop Asset ID',
        currentId: currentId
    });
    setupRealtimeValidation({
        inputSelector: 'input[name="email"]',
        checkUrl: "{{ route('users.check-unique') }}",
        fieldName: 'email',
        label: 'Email',
        currentId: currentId
    });
});
</script>
@endsection
