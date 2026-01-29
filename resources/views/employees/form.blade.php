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
                            <option value="N/A" {{ in_array(old('asset_id', $employee->asset_id), ['N/A', '', null]) ? 'selected' : '' }}>N/A</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->asset_id }}" 
                                    {{ old('asset_id', $employee->asset_id) == $asset->asset_id ? 'selected' : '' }}>
                                    {{ $asset->asset_id }} ({{ $asset->device_model }})
                                </option>
                            @endforeach
                        </select>
                    </td>
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
