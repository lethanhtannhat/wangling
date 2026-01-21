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
            @if($isEdit)
                @method('PUT')
            @endif

            <table>
                <tr>
                    <td class="label-col">Asset ID</td>
                    <td class="input-col">
                        <input type="text" name="asset_id" id="asset_id" value="{{ old('asset_id', $asset->asset_id ?? '') }}" class="@error('asset_id') is-invalid @enderror" required>
                        @error('asset_id')
                            <div class="invalid-feedback" style="display:block; color:red; font-size:0.8rem;">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>

                    <td class="label-col">Win or Mac</td>
                    <td class="input-col">
                        <select name="os" required>
                            <option value="Win" {{ old('os', $asset->os ?? '') == 'Win' ? 'selected' : '' }}>Win</option>
                            <option value="Mac" {{ old('os', $asset->os ?? '') == 'Mac' ? 'selected' : '' }}>Mac</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Device Model</td>
                    <td class="input-col">
                        <input type="text" name="device_model" value="{{ old('device_model', $asset->device_model ?? '') }}" required>
                    </td>

                    <td class="label-col">Chip</td>
                    <td class="input-col">
                        <input type="text" name="chip" value="{{ old('chip', $asset->chip ?? '') }}" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Memory (GB)</td>
                    <td class="input-col">
                        <input type="number" name="memory" min="0" step="0.01" value="{{ old('memory', $asset->memory ?? '') }}" required>
                    </td>

                    <td class="label-col">Storage (GB)</td>
                    <td class="input-col">
                        <input type="number" name="storage" min="0" step="0.01" value="{{ old('storage', $asset->storage ?? '') }}" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Serial Number</td>
                    <td class="input-col">
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number ?? '') }}" class="@error('serial_number') is-invalid @enderror" required>
                        @error('serial_number')
                            <div class="invalid-feedback" style="display:block; color:red; font-size:0.8rem;">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>

                    <td class="label-col">Release Year</td>
                    <td class="input-col">
                        <input type="number" name="release_year" min="1900" max="{{ date('Y') + 10 }}" value="{{ old('release_year', $asset->release_year ?? '') }}" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Purchase Date</td>
                    <td class="input-col">
                        <input type="text" name="purchase_date" id="purchaseDate" placeholder="yyyy-mm-dd" value="{{ old('purchase_date', $asset->purchase_date ?? '') }}" required>
                    </td>
                    <td class="label-col"></td>
                    <td class="input-col"></td>
                </tr>
            </table>

            @if($isEdit)
                <input type="hidden" id="asset_id_hidden" value="{{ $asset->id }}">
            @endif

            <button type="submit" class="btn-submit mt-3">{{ $buttonText }}</button>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom:0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    $("#purchaseDate").datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom",
        container: "body"
    });

    @php $checkRoute = Route::has('assets.check-unique') ? route('assets.check-unique') : null; @endphp
    @if($checkRoute)
    function checkUniqueness($input, fieldName, label) {
        const value = $input.val();
        const currentId = $('#asset_id_hidden').length ? $('#asset_id_hidden').val() : null;

        if (value.length > 0) {
            $.ajax({
                url: "{{ $checkRoute }}", 
                method: "GET",
                data: { 
                    field: fieldName,
                    value: value,
                    current_id: currentId
                },
                success: function (response) {
                    $input.removeClass('is-invalid');
                    $input.next('.dynamic-error').remove();

                    if (response.exists) {
                        $input.addClass('is-invalid');
                        $input.after('<div class="invalid-feedback dynamic-error" style="display:block; color:red; font-size:0.8rem;">' + label + ' has already existed.</div>');
                        updateSubmitButton();
                    } else {
                        updateSubmitButton();
                    }
                }
            });
        }
    }

    function updateSubmitButton() {
        const hasErrors = $('.is-invalid').length > 0;
        $('button[type="submit"]').prop('disabled', hasErrors);
    }

    $('#asset_id').on('blur', function () {
        checkUniqueness($(this), 'asset_id', 'Asset ID');
    });

    $('#serial_number').on('blur', function () {
        checkUniqueness($(this), 'serial_number', 'Serial Number');
    });
    @endif
});
</script>
@endsection
