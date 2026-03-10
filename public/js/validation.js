/**
 * Real-time uniqueness validation
 */
window.setupRealtimeValidation = function (options) {
    const { inputSelector, checkUrl, fieldName, label, currentId } = options;

    $(inputSelector).on('blur', function () {
        const $input = $(this);
        const value = $input.val();

        if (value.length > 0) {
            $.ajax({
                url: checkUrl,
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
                        $input.after('<div class="invalid-feedback dynamic-error" style="display:block; color:red; font-size:0.8rem;">' + label + ' has already been taken.</div>');
                    }
                    updateSubmitButtonState($input.closest('form'));
                }
            });
        } else {
            $input.removeClass('is-invalid');
            $input.next('.dynamic-error').remove();
            updateSubmitButtonState($input.closest('form'));
        }
    });

    function updateSubmitButtonState($form) {
        const hasErrors = $form.find('.is-invalid').length > 0;
        $form.find('button[type="submit"]').prop('disabled', hasErrors);
    }
};

/**
 * Auto-expand textarea
 */
$(document).on('input', 'textarea.auto-expand', function () {
    this.style.height = 'inherit';
    this.style.height = this.scrollHeight + 'px';
});

// Initial trigger for edit forms
$(function () {
    $('textarea.auto-expand').trigger('input');
});
