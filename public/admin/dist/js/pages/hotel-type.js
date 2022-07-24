$(document).ready(function () {
    $('#hotel_type_table').DataTable({ "order": [] });
});

//create
$(document).on('click', '#hotel_type_create', function () {
    $('#hotel_type_form_div').slideToggle();
    $(this).text($(this).text() == 'Create' ? 'Close' : 'Create');
});

