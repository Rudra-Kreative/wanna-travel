function previewUpdatedImages(src, dest, showSec = '') {

    var total_file = document.getElementById(src).files.length;
    if ($('#' + src).hasClass('limitMultiple') && ($('#' + src).attr('data-limit') != 'undefined')) {
        if (total_file > parseInt($('#' + src).attr('data-limit'))) {
            alert('Only ' + $('#' + src).attr('data-limit') + 'images are allowed for this section');
            $('#' + dest).html('');
            $('#' + showSec).fadeOut(600);
            return false;
        }
    }

    const obj = JSON.parse($('#selected_banner_image').val());
    var appendHtml = "";

    for (let index = 0; index < total_file; index++) {

        appendHtml += "<div class='col-md-4 previewImgDiv'><img class='rounded previewImg'  style='width: 100%; height:200px' src='" + URL.createObjectURL(event.target.files[index]) + "'>"
            + "<button type='button' data-name=" + event.target.files[index].name + " class='btn banner_image_remove_btn' title='Remove Image'>Remove</button>"
            + "</div>";


        var isPresent = false;
        $.each(obj, function (indexInArray, valueOfElement) {
            if (valueOfElement == event.target.files[index].name) {
                isPresent = true;
            }
        });

        if (!isPresent) {
            obj.push(event.target.files[index].name)
        }
    }
    if ($('#' + dest + ' .container .row .previewImgDiv:last').length == 0) {
        $('#' + dest + ' .container .row .banner_add_icon_div').before(appendHtml);

    }
    else {
        $('#' + dest + ' .container .row .previewImgDiv:last').after(appendHtml);
    }

    if (total_file > 0) {

        $('#' + showSec).fadeIn(600);
    }
    else {
        //$('#' + showSec).fadeOut(600);
    }

    $('#selected_banner_image').val(JSON.stringify(obj));
}


$(document).on('click', '.updated_banner_image_icon', function () {
    $('#updated_banner_images').trigger('click');
});



$(document).on('click', '.banner_image_remove_btn', function () {
    const obj = JSON.parse($('#selected_banner_image').val());

    thisFile = $(this).attr('data-name');
    $.each(obj, function (indexInArray, valueOfElement) {
        if (valueOfElement == thisFile) {
            delete obj[indexInArray];
        }
    });
    $('#selected_banner_image').val(JSON.stringify(obj));
    $(this).closest('.previewImgDiv').remove();
});


function previewImages(src, dest, showSec = '') {

    var total_file = document.getElementById(src).files.length;
    if ($('#' + src).hasClass('limitMultiple') && ($('#' + src).attr('data-limit') != 'undefined')) {
        if (total_file > parseInt($('#' + src).attr('data-limit'))) {
            alert('Only ' + $('#' + src).attr('data-limit') + 'images are allowed for this section');
            $('#' + dest).html('');
            $('#' + showSec).fadeOut(600);
            $('#' + src).val('');
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