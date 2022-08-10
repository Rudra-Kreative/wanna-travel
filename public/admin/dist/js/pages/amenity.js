$(document).ready(function(){
    $('#amenity_table').DataTable({ "order": [] });
});
//create
$(document).on('click', '#amenity_create', function () {
    $('#amenity_form_div').slideToggle();
    $(this).text($(this).text() == 'Create' ? 'Close' : 'Create');
});