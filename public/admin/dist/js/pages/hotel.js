
$(document).ready(function () {
    //$('#hotel_table').DataTable({ "order": [] });
});

//create
$(document).on('click', '#hotel_create', function () {
    $('#hotel_form_div').slideToggle();
    $(this).text($(this).text() == 'Create' ? 'Close' : 'Create');
});


function previewHotelImages() {
    var total_file = document.getElementById("avatars").files.length;
    var appendHtml = '';
    alert(total_file);
    for (let index = 0; index < total_file; index++) {

        appendHtml += "<div class='column'><img class='rounded' style='weight: 200px;height:200px' src='" + URL.createObjectURL(event.target.files[index]) + "'></div>";

        $('#avatar_preview').append(appendHtml);

    }
    if (total_file > 0) {

        $('#avatar_preview_sec').fadeIn(600);
    }
    else {
        $('#avatar_preview_sec').fadeOut(600);
    }
}
