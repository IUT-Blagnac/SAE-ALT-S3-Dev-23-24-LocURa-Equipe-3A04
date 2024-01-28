$(document).ready(function() {
    $('.select-all').change(function() {
        var isChecked = $(this).is(':checked');
        $(this).closest('.dropdown-content').find('input[type=checkbox]').prop('checked', isChecked);
    });
});