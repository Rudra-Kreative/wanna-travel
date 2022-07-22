
$(document).on('click','.bootstrap-switch',function(){
    $(this).toggleClass('bootstrap-switch-on bootstrap-switch-off');
    if($(this).hasClass('bootstrap-switch-on'))
    {
        $('.bootstrap-switch-container').css('margin-left','0px');
        $( "#faq-active-checkbox" ).prop( "checked", true );

    }
    else{
        $( "#faq-active-checkbox" ).prop( "checked", false );
        $('.bootstrap-switch-container').css('margin-left','-70px');
    }
    
});


$(document).on('change', '#faq_ques', function () {
    if ($(this).val() == 'create') {
        $('#faq_form').attr('data-action', '/administrator/pages/store');
        $('#faq_button').attr('data-method', 'create');
        $('#ques').val('');
        $('#answer').val('');
        $('#faq_button').html('Create');
        $('#faq_button').attr('disabled',false);
        $('.fac_active_button').fadeIn(600);
        $('.ques_answer_div').fadeIn(600);
    }
    else if ($(this).val() !== '' && $(this).val() !== 'undefined') {
        var faq_data = $('#faq_data').val();
        var this_ques = $(this).val().trim();
        if (faq_data !== '' && faq_data != 'undefined') {
            faq_data = JSON.parse(faq_data);
            this_answer = '';
            $.each(faq_data, function (index, value) {
                if (value.ques == this_ques) {
                    this_answer = value.answer;
                    if(value.is_active == 'true')
                    {   
                        $('.bootstrap-switch').addClass('bootstrap-switch-on');
                        $('.bootstrap-switch-container').css('margin-left','0px');
                        $( "#faq-active-checkbox" ).prop( "checked", true );
                    }
                    else
                    {
                        $('.bootstrap-switch').addClass('bootstrap-switch-of');
                        $('.bootstrap-switch-container').css('margin-left','-72px');
                        $( "#faq-active-checkbox" ).prop( "checked", false );
                    }
                    return false;
                }
            });

            $('#ques').val(this_ques);
            $('#answer').val(this_answer);
            $('#faq_form').attr('data-action', '/administrator/pages/' + $('#faq_form').attr('data-id') + '/update');
            $('#faq_button').attr('data-method', 'update');
            $('#faq_button').html('Update');
            $('#faq_button').attr('disabled',false);
            $('.fac_active_button').fadeIn(600);
            $('.ques_answer_div').fadeIn(600);
        }
    }
    else {
        $('#faq_form').attr('data-action', '');
        $('#faq_button').attr('data-method', '');
        $('#faq_button').html('No action permitted');
        $('#faq_button').attr('disabled',true);
        $('.fac_active_button').fadeOut(600);
        $('.ques_answer_div').fadeOut(600);
    }
});

$(document).on('click', '#faq_button', function () {

    if ($(this).attr('data-method') !== 'undefined') {
        switch ($(this).attr('data-method')) {
            case 'create':
                createFaq();
                break;
            case 'update':
                updateFaq();
                break;
            default:
                break;
        }
    }
});


function createFaq() {
    var ques = $('#ques').val().trim();
    var ans = $('#answer').val().trim();
    var is_active = $('#faq-active-checkbox').prop('checked');
    var page_indentifier = $('#page_indentifier').val().trim();
    if (ques == '' || ques == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter a question'
        })
    }

    else if (ans == '' || ans == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter an answer'
        })
    }
    else if (page_indentifier == '' || page_indentifier == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Error!! Reload the page and try again later'
        })
    }

    else {

        var dataTarget = $('#faq_form').attr('data-action');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: dataTarget,
            data: { 'ques': ques, 'answer': ans, 'page_indentifier': page_indentifier,'is_active':is_active },
            dataType: "json",
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Storing...');
            },
            success: function (response) {

                if ((response.data.templates.contents !== '') && (response.data.templates.contents !== 'undefined') && (response.data.templates.contents.length > 0)) {
                    appendableQues = '<option value="" selected>Select a question</option>';
                    appendableQues += '<option value="create">Create a new one +</option>';
                    $.each(response.data.templates.contents, function (indexInArray, valueOfElement) {
                        appendableQues += '<option value="' + valueOfElement.ques + '">' + valueOfElement.ques + '</option>';
                    });

                    $('#ques').val('');
                    $('#answer').val('');
                    $('#faq_data').val(JSON.stringify(response.data.templates.contents));
                    $('#faq_ques').html(appendableQues);
                    Toast.fire({
                        icon: 'success',
                        title: 'FAQ has been added successfully'
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
function updateFaq() { 

    var ques = $('#ques').val().trim();
    var ans = $('#answer').val().trim();
    var is_active = $('#faq-active-checkbox').prop('checked');
    var page_indentifier = $('#page_indentifier').val().trim();
    if (ques == '' || ques == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter a question'
        })
    }

    else if (ans == '' || ans == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter an answer'
        })
    }
    else if (page_indentifier == '' || page_indentifier == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Error!! Reload the page and try again later'
        })
    }

    else
    {
        var dataTarget = $('#faq_form').attr('data-action');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: dataTarget,
            data: { 'ques': ques, 'answer': ans, 'is_active':is_active, 'page_indentifier': page_indentifier, '_method':'PUT', 'old_ques': $('#faq_ques').val().trim() },
            dataType: "json",
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Updating...');
            },
            success: function (response) {

                if ((response.data.templates.contents !== '') && (response.data.templates.contents !== 'undefined') && (response.data.templates.contents.length > 0)) {
                    appendableQues = '<option value="" selected>Select a question</option>';
                    appendableQues += '<option value="create">Create a new one +</option>';
                    $.each(response.data.templates.contents, function (indexInArray, valueOfElement) {
                        appendableQues += '<option value="' + valueOfElement.ques + '" '+(valueOfElement.ques == $('#faq_ques').val().trim() ? 'selected' : '')+'>' + valueOfElement.ques + '</option>';
                    });

                    $('#ques').val(ques);
                    $('#answer').val(ans);
                    
                    $('#faq_data').val(JSON.stringify(response.data.templates.contents));
                    $('#faq_ques').html(appendableQues);
                    Toast.fire({
                        icon: 'success',
                        title: 'FAQ has been updated successfully'
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


