@extends('layouts.app')

@section('title', 'Create Asset')
@section('header', 'Create Asset')

@section('content')
<div class="section">
    <div class="section-body">
        <form method="POST" action="{{ route('assets.store') }}">
            @csrf

            <table>
                <tr>
                    <td class="label-col">Asset ID</td>
                    <td class="input-col">
                        <input type="text" name="asset_id" id="asset_id" value="{{ old('asset_id') }}" class="@error('asset_id') is-invalid @enderror" required>
                        @error('asset_id')
                            <div class="invalid-feedback" style="display:block; color:red; font-size:0.8rem;">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>

                    <td class="label-col">Win or Mac</td>
                    <td class="input-col">
                        <select name="os" required>
                            <option value="Win" {{ old('os') == 'Win' ? 'selected' : '' }}>Win</option>
                            <option value="Mac" {{ old('os') == 'Mac' ? 'selected' : '' }}>Mac</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Device Model</td>
                    <td class="input-col">
                        <input type="text" name="device_model" value="{{ old('device_model') }}" required>
                    </td>

                    <td class="label-col">Chip</td>
                    <td class="input-col">
                        <input type="text" name="chip" value="{{ old('chip') }}" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Memory (GB)</td>
                    <td class="input-col">
                        <input type="number" name="memory" min="0" step="0.01" value="{{ old('memory') }}" required>
                    </td>

                    <td class="label-col">Storage (GB)</td>
                    <td class="input-col">
                        <input type="number" name="storage" min="0" step="0.01" value="{{ old('storage') }}" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Serial Number</td>
                    <td class="input-col">
                        <input type="text" name="serial_number" value="{{ old('serial_number') }}" required>
                    </td>

                    <td class="label-col">Purchase Date</td>
                    <td class="input-col">
                        <input type="text" name="purchase_date" id="purchaseDate" placeholder="yyyy-mm-dd" value="{{ old('purchase_date') }}" required>
                    </td>
                </tr>
            </table>

            <button type="submit" class="btn-submit mt-3">Create</button>
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

    @php $checkIdRoute = Route::has('assets.check-id') ? route('assets.check-id') : null; @endphp
    @if($checkIdRoute)
    $('#asset_id').on('blur', function () {
        const assetId = $(this).val();
        const $input = $(this);

        if (assetId.length > 0) {
            $.ajax({
                url: "{{ $checkIdRoute }}", 
                method: "GET",
                data: { 
                    asset_id: assetId
                },
                success: function (response) {
                    $input.removeClass('is-invalid');
                    $('.dynamic-error').remove();

                    if (response.exists) {
                        $input.addClass('is-invalid');
                        $input.after('<div class="invalid-feedback dynamic-error" style="display:block; color:red; font-size:0.8rem;">Asset ID has already existed.</div>');
                        $('button[type="submit"]').prop('disabled', true);
                    } else {
                        $('button[type="submit"]').prop('disabled', false); 
                    }
                }
            });
        }
    });
    @endif
});
</script>
@endsection
