@extends('layouts.app')

@section('title', 'Create User')
@section('header', 'Create User')

@section('content')
<div class="section">
    <div class="section-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <table>
                <tr>
                    <td class="label-col">Department</td>
                    <td class="input-col">
                        <input type="text" name="department" value="{{ old('department') }}">
                    </td>

                    <td class="label-col">Team</td>
                    <td class="input-col">
                        <input type="text" name="team" value="{{ old('team') }}">
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Name</td>
                    <td class="input-col">
                        <input type="text" name="name" value="{{ old('name') }}" required>
                    </td>

                    <td class="label-col">Email</td>
                    <td class="input-col">
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Laptop Asset ID</td>
                    <td class="input-col">
                        <input type="text" name="asset_id" id="asset_id" value="{{ old('asset_id') }}"  >
                    </td>
                    <td class="label-col"></td>
                    <td class="input-col"></td>
                </tr>
            </table>

            <button type="submit" class="btn-submit mt-3">Create</button>
            
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
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
    function checkUniqueness($input, fieldName, label) {
        const value = $input.val();
        if (value.length > 0) {
            $.ajax({
                url: "{{ route('users.check-unique') }}",
                method: "GET",
                data: { 
                    field: fieldName,
                    value: value
                },
                success: function (response) {
                    $input.removeClass('is-invalid');
                    $input.next('.dynamic-error').remove();

                    if (response.exists) {
                        $input.addClass('is-invalid');
                        $input.after('<div class="invalid-feedback dynamic-error" style="display:block; color:red; font-size:0.8rem;">' + label + ' has already been assigned to another user.</div>');
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
        checkUniqueness($(this), 'asset_id', 'Laptop Asset ID');
    });

    $('input[name="email"]').on('blur', function () {
        checkUniqueness($(this), 'email', 'Email');
    });
});
</script>
@endsection
