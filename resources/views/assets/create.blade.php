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
                        <input type="text" name="asset_id" required>
                    </td>

                    <td class="label-col">Win or Mac</td>
                    <td class="input-col">
                        <select name="os" required>
                            <option value="Win">Win</option>
                            <option value="Mac">Mac</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Device Model</td>
                    <td class="input-col">
                        <input type="text" name="device_model" required>
                    </td>

                    <td class="label-col">Chip</td>
                    <td class="input-col">
                        <input type="text" name="chip" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Memory (GB)</td>
                    <td class="input-col">
                        <input type="number" name="memory" min="0" step="0.01" required>
                    </td>

                    <td class="label-col">Storage (GB)</td>
                    <td class="input-col">
                        <input type="number" name="storage" min="0" step="0.01" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Serial Number</td>
                    <td class="input-col">
                        <input type="text" name="serial_number" required>
                    </td>

                    <td class="label-col">Purchase Date</td>
                    <td class="input-col">
                        <input type="text" name="purchase_date" id="purchaseDate" placeholder="yyyy-mm-dd" required>
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
});
</script>
@endsection
