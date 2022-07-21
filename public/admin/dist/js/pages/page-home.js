function previewImages(src, dest, showSec = '') {

    var total_file = document.getElementById(src).files.length;
    if ($('#' + src).hasClass('limitMultiple') && ($('#' + src).attr('data-limit') != 'undefined')) {
        if (total_file > parseInt($('#' + src).attr('data-limit'))) {
            alert('Only ' + $('#' + src).attr('data-limit') + 'images are allowed for this section');
            $('#' + dest).html('');
            $('#' + showSec).fadeOut(600);
            return false;
        }
    }
    var appendHtml = "<div class='row'>";

    for (let index = 0; index < total_file; index++) {

        appendHtml += "<div class='col-md-4'><img class='rounded previewImg' style='width: 100%; height:200px' src='" + URL.createObjectURL(event.target.files[index]) + "'></div>";

    }
    $('#' + dest).html(appendHtml + "</div>");
    if (total_file > 0) {

        $('#' + showSec).fadeIn(600);
    }
    else {
        $('#' + showSec).fadeOut(600);
    }
}



