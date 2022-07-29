$(document).on('change', '#section_select', function () {
    $('#section_image').val(null);
    if ($(this).val() !== '' && $(this).val() !== 'undefined') {
        var section_data = $('#is_wanna_data').val().trim();
        var this_sec = $(this).val().trim();
        var isFound = false;
        if (section_data !== '' && section_data !== 'undefined') {
            section_data = JSON.parse(section_data);
            
            $.each(section_data, function (index, value) {

                if (value.section == this_sec) {
                    $('#section_text').val(value.section_text);
                    var imgHtml = "<div class='row'><div class='col-md-4'>";
                    imgHtml += "<img class='rounded previewImg' style='width: 100%; height:200px' src='/" + value.section_image[0].filePath + "'></div></div>";

                    $('#section_image_preview').html(imgHtml);
                    $('#section_image_preview_sec').fadeIn(600);
                    $('#sec_button').html('Update');
                    $('#is_wanna_for_me').attr('data-action', '/administrator/pages/' + $('#is_wanna_for_me').attr('data-slug') + '/update');
                    $('#sec_button').attr('disabled', false);
                    $('#sec_button').attr('data-method', 'update');
                    $('.section_detailed_div').fadeIn(600);
                    isFound = true;
                    return false;
                }
            });

            if (!isFound) {
                $('#section_text').val('');
                $('#section_image_preview').html('');
                $('#sec_button').html('Create');
                $('#sec_button').attr('data-method', 'create');
                $('#is_wanna_for_me').attr('data-action', '/administrator/pages/store');
                $('#sec_button').attr('disabled', false);
                $('.section_detailed_div').fadeIn(600);
            }
        }
        else {
            if (!isFound) {
                $('#section_text').val('');
                $('#section_image_preview').html('');
                $('#sec_button').html('Create');
                $('#sec_button').attr('data-method', 'create');
                $('#is_wanna_for_me').attr('data-action', '/administrator/pages/store');
                $('#sec_button').attr('disabled', false);
                $('.section_detailed_div').fadeIn(600);
            }
        }

    }
    else {
        $('#is_wanna_for_me').attr('data-action', '');
        $('#sec_button').attr('data-method', '');
        $('#sec_button').html('No action permitted');
        $('#section_text').val('');
        $('#section_image_preview').html('');
        $('#sec_button').attr('disabled', true);
        $('.section_detailed_div').fadeOut(600);
    }

});


$(document).on('click', '#sec_button', function () {

    if ($(this).attr('data-method') !== 'undefined') {
        switch ($(this).attr('data-method')) {
            case 'create':
                createSection();
                break;
            case 'update':
                updateSection();
                break;
            default:
                break;
        }
    }

});


function createSection() {
    var this_sec = $('#section_select').val().trim();
    var this_text = $('#section_text').val().trim();
    var this_img = document.getElementById('section_image');
    var page_indentifier = $('#page_indentifier').val().trim();

    var formData = new FormData();

    if (this_text == '' || this_text == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter some texts for the section'
        });
    }
    else if (this_img.files.length <= 0) {
        Toast.fire({
            icon: 'error',
            title: 'Please select an image for the section'
        });
    }

    else {
        var dataTarget = $('#is_wanna_for_me').attr('data-action');

        formData.append('this_sec', this_sec);
        formData.append('section_text', this_text);
        formData.append('section_image', this_img.files[0]);
        formData.append('page_indentifier', page_indentifier);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: dataTarget,
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Storing...');
            },
            success: function (response) {

                if (response.data.response.key == 'success') {
                    if ((response.data.templates.contents !== '') && (response.data.templates.contents !== 'undefined') && (response.data.templates.contents.length > 0)) {
                        $('#section_image').val(null);
                        $('#is_wanna_data').val(JSON.stringify(response.data.templates.contents));

                        Toast.fire({
                            icon: 'success',
                            title: 'Section has been stored successfully'
                        })
                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error!! Reload the page and try again'
                        })
                    }
                }
                else {
                    Toast.fire({
                        icon: 'error',
                        title: response.data.response.message
                    })
                }

            },
            error: function (request, status, error) {
                responses = jQuery.parseJSON(request.responseText);

                if (responses.errors) {
                    var errorHtml = '<ul>';
                    $.each(responses.errors, function (key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';

                    Toast.fire({
                        icon: 'error',
                        title: errorHtml
                    })

                }
            },
            complete: function () {
                $('#spinner-loader').fadeOut(100);
            }
        });
    }
}

function updateSection() {

    var this_sec = $('#section_select').val().trim();
    var this_text = $('#section_text').val().trim();
    var this_img = document.getElementById('section_image');
    var page_indentifier = $('#page_indentifier').val().trim();

    var formData = new FormData();

    if (this_text == '' || this_text == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter some texts for the section'
        });
    }
    else {
        var dataTarget = $('#is_wanna_for_me').attr('data-action');

        formData.append('this_sec', this_sec);
        formData.append('section_text', this_text);
        if (this_img.files.length > 0) {
            formData.append('section_image', this_img.files[0]);
        }
        formData.append('page_indentifier', page_indentifier);
        formData.append('_method', 'PUT');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: dataTarget,
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Updating...');
            },
            success: function (response) {
                if ((response.data.templates.contents !== '') && (response.data.templates.contents !== 'undefined') && (response.data.templates.contents.length > 0)) {
                    $('#is_wanna_data').val(JSON.stringify(response.data.templates.contents));
                    $('#section_image').val(null);
                    Toast.fire({
                        icon: 'success',
                        title: 'Section has been updated successfully'
                    })
                }
                else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error!! Reload the page and try again'
                    })
                }
            },
            error: function (request, status, error) {
                responses = jQuery.parseJSON(request.responseText);

                if (responses.errors) {
                    var errorHtml = '<ul>';
                    $.each(responses.errors, function (key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';

                    Toast.fire({
                        icon: 'error',
                        title: errorHtml
                    })

                }
            },
            complete: function () {
                $('#spinner-loader').fadeOut(100);
            }
        });
    }


}

function previewImages(src, dest, showSec = '') {

    var total_file = document.getElementById(src).files.length;

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
