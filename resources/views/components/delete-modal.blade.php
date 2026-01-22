@props(['id', 'title', 'message', 'actionUrl' => ''])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="{{ $id }}Form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    {{ $message }} <strong class="delete-item-name"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#{{ $id }}').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const url = button.data('action-url');
        const name = button.data('display-name');
        
        $('#{{ $id }}Form').attr('action', url);
        $('#{{ $id }} .delete-item-name').text(name);
    });
});
</script>
