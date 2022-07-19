//create
$(document).on('click', '#property_type_create', function () {
    $('#property_type_form_div').slideToggle();
    $(this).text($(this).text() == 'Create' ? 'Close' : 'Create');
});

$(document).ready(function () {
    $('#property_type_table').DataTable({ "order": [] });
});
