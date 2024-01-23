$(document).ready(function() {
    // Attach a change event listener to all "Select All" checkboxes
    $('.select-all').change(function() {
        // Get the state of the "Select All" checkbox
        var isChecked = $(this).is(':checked');

        // Check or uncheck all other checkboxes in the same dropdown
        $(this).closest('.dropdown-content').find('input[type=checkbox]').prop('checked', isChecked);
    });
});