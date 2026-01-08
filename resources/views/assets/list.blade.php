@extends('layouts.app')

@section('title', 'Asset List')
@section('header', 'Asset List')

@section('content')

@if(config('features.asset_filter'))
    @include('assets.partials.filter')
@endif

@include('assets.partials.table')

@if(config('features.asset_edit'))
    @include('assets.partials.edit-modal')
@endif

@if(config('features.asset_delete'))
    @include('assets.partials.delete-modal')
@endif



@endsection

@section('scripts')
<script>
$(function () {
    
    $("#fromDate, #toDate, #edit_date").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        container: "body"
    });

    
    $('#editModal').on('show.bs.modal', function (event) {
        const btn = $(event.relatedTarget);
        
        
        if (btn.length > 0) {
            const id = btn.data('id');
            const actionUrl = '/assets/' + id;
            
            $('#editForm').attr('action', actionUrl);
            $('#edit_id').val(id); 
            
            
            $('#edit_asset_id').val(btn.data('asset_id')).removeClass('is-invalid');
            $('#edit_device_model').val(btn.data('device_model'));
            $('#edit_os').val(btn.data('os'));
            $('#edit_chip').val(btn.data('chip'));
            $('#edit_memory').val(btn.data('memory'));
            $('#edit_storage').val(btn.data('storage'));
            $('#edit_serial').val(btn.data('serial'));
            $('#edit_date').val(btn.data('date'));
            
            
            $('.dynamic-error').remove();
            $('#editForm button[type="submit"]').prop('disabled', false);
        } 
        
        else {
            const oldId = $('#edit_id').val();
            if (oldId) {
                $('#editForm').attr('action', '/assets/' + oldId);
            }
        }
    });

    
    @php $checkIdRoute = Route::has('assets.check-id') ? route('assets.check-id') : null; @endphp
    @if($checkIdRoute)
    $('#edit_asset_id').on('blur', function () {
        const assetId = $(this).val();
        const currentId = $('#edit_id').val(); 
        const $input = $(this);
        const $submitBtn = $('#editForm button[type="submit"]');

        if (assetId.length > 0) {
            $.ajax({
                url: "{{ $checkIdRoute }}", 
                method: "GET",
                data: { 
                    asset_id: assetId,
                    current_id: currentId 
                },
                success: function (response) {
                    $input.removeClass('is-invalid');
                    $input.parent().find('.dynamic-error').remove();

                    if (response.exists) {
                        $input.addClass('is-invalid');
                        $input.after('<div class="invalid-feedback dynamic-error" style="display:block; color:red; font-size:0.8rem;">Asset ID has already existed.</div>');
                        $submitBtn.prop('disabled', true);
                    } else {
                        $submitBtn.prop('disabled', false); 
                    }
                }
            });
        }
    });
    @endif



   
    $('#deleteModal').on('show.bs.modal', function (event) {
        const id = $(event.relatedTarget).data('id');
        $('#deleteForm').attr('action', '/assets/' + id);
    });

    
    @if ($errors->any())
        const modalEl = document.getElementById('editModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    @endif
});
</script>
@endsection
