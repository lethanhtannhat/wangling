@extends('layouts.app')

@section('title', 'Asset List')
@section('header', 'Asset List')

@section('content')

@if(config('features.asset_filter'))
    @include('assets.partials.filter')
@endif

@include('assets.partials.table')



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

    




   
    $('#deleteModal').on('show.bs.modal', function (event) {
        const id = $(event.relatedTarget).data('id');
        $('#deleteForm').attr('action', '/assets/' + id);
    });

    

});
</script>
@endsection
