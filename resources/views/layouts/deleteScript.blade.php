<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var link   = $(event.relatedTarget);
        var resourceId = link.data('resource-id');
        var action = link.data('action');
        var title = link.data('title');
        var message = link.data('message');

        $('#deleteTitle')[0].innerText = title;
        message = message.replace(':id', resourceId);
        $('#deleteMessage')[0].innerText = message;
        $(this).find('.modal-footer form').attr('action', action);
    });
</script>