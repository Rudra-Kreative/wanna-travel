

$(document).on('change', '#plan', function () {
    if ($(this).val() !== '' && $(this).val() !== 'undefined') {
        var plan_data = $('#plan_data').val().trim();
        var thisVal = $(this).val();
        var dataMethod = $('#plan_form').attr('data-method');
        if (plan_data !== '' && plan_data !== 'undefined') {
            plan_data = JSON.parse(plan_data);

            $.each(plan_data, function (index, value) {

                if (thisVal == value.id) {
                    $('#price').val(parseFloat(value.price).toFixed(2));
                    if (value.plan_features.length > 0) {
                        var appentableElement = '';
                        $.each(value.plan_features, function (indexInArray, valueOfElement) {


                            if (indexInArray == 0) {
                                appentableElement += '<div style="display: flex;padding-top: 2px;" class="addFeatureDiv">' +
                                    '<input type="text" class="form-control" name="features[]" data-featureId=' + valueOfElement.id + ' value="' + valueOfElement.name + '">' +
                                    "<i class='fas fa-plus-circle addFeatureBtn'style='font-size: 25px;" +
                                    "color: rgb(44, 49, 45);cursor: pointer;padding-left: 10px;padding-top: 5px;'" +
                                    'title="Add feature"></i></div>';
                            }
                            else {
                                appentableElement += '<div style="display: flex;padding-top: 2px;" class="addFeatureDiv">' +
                                    '<input type="text" class="form-control" name="features[]" data-featureId=' + valueOfElement.id + ' value="' + valueOfElement.name + '">' +
                                    "<i class='fas fa-minus-circle removeFeatureBtn'style='font-size: 25px;" +
                                    "color: rgb(205 51 51);cursor: pointer;padding-left: 10px;padding-top: 5px;'" +
                                    'title="Remove feature"></i></div>';
                            }


                        });

                        $('.featureDiv').html(appentableElement);
                    }
                    else {
                        $('.featureDiv').html('<div style="display: flex;padding-top: 2px;" class="addFeatureDiv">' +
                            '<input type="text" class="form-control" name="features[]" data-featureId="" value="">' +
                            "<i class='fas fa-plus-circle addFeatureBtn'style='font-size: 25px;" +
                            "color: rgb(44, 49, 45);cursor: pointer;padding-left: 10px;padding-top: 5px;'" +
                            'title="Add feature"></i></div>');
                    }
                    $('#plan_form').attr('data-action', '/administrator/pages/' + (dataMethod == 'create' ? 'store' : (dataMethod == 'update' ?  $('#plan_form').attr('data-slug') +'/update' : '')));
                    $('.planUpdateBtn').html((dataMethod == 'create' ? 'Create' : (dataMethod == 'update' ? 'Update' : '')));
                    $('.descriptiveDiv').fadeIn(600);
                    $('.planUpdateBtn').attr('disabled', false);
                    return false;

                }

            });


        }
        else {
            $('.featureDiv').html('<div style="display: flex;padding-top: 2px;" class="addFeatureDiv">' +
                '<input type="text" class="form-control" name="features[]" data-featureId="" value="">' +
                "<i class='fas fa-plus-circle addFeatureBtn'style='font-size: 25px;" +
                "color: rgb(44, 49, 45);cursor: pointer;padding-left: 10px;padding-top: 5px;'" +
                'title="Add feature"></i></div>');
            $('.descriptiveDiv').fadeOut(600);
        }
    }
    else {
        $('.featureDiv').html('<div style="display: flex;padding-top: 2px;" class="addFeatureDiv">' +
            '<input type="text" class="form-control" name="features[]" data-featureId="" value="">' +
            "<i class='fas fa-plus-circle addFeatureBtn'style='font-size: 25px;" +
            "color: rgb(44, 49, 45);cursor: pointer;padding-left: 10px;padding-top: 5px;'" +
            'title="Add feature"></i></div>');
        $('.descriptiveDiv').fadeOut(600);
    }
});

$(document).on('click', '.addFeatureBtn', function () {
    var appentableElement = '<div style="display: flex;padding-top: 2px;" class="addFeatureDiv">' +
        '<input type="text" class="form-control" name="features[]">' +
        "<i class='fas fa-minus-circle removeFeatureBtn'style='font-size: 25px;" +
        "color: rgb(205 51 51);cursor: pointer;padding-left: 10px;padding-top: 5px;'" +
        'title="Add feature"></i></div>';
    $(this).closest('.featureDiv').append(appentableElement);
});

$(document).on('click', '.removeFeatureBtn', function () {
    $(this).closest('.addFeatureDiv').remove();
});


$(document).on('click', '.planUpdateBtn', function () {

    var dataMethod = $('#plan_form').attr('data-method');
    if (dataMethod !== '' && dataMethod !== 'undefined') {
        switch (dataMethod) {
            case 'create':
                createPlan();
                break;
            case 'update':
                updatePlan();
                break;

            default:
                break;
        }
    }
    else {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong.. Reload the page and try again'
        });
    }

});


function createPlan() {

    var plan = $('#plan').val();
    var withPlan = false;
    var isValidated = false;

    if (plan !== '' && plan !== 'undefined') {

        withPlan = true;
    }

    if ($('#heading').val() == '' || $('#heading').val() == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter page heading'
        });
    }

    else if (withPlan) {
        isValidated = false;
        var features = $('input[name^=features]').map(function (idx, elem) {
            if ($(elem).val().trim() !== '' && $(elem).val().trim() !== 'undefined') {
                return $(elem).val();
            }
        }).get();

        if ($('#plan').val() == '' || $('#plan').val() == 'undefined') {
            Toast.fire({
                icon: 'error',
                title: 'Please select a plan'
            });
        }
        else if ($('#price').val() == '' || $('#price').val() == 'undefined') {
            Toast.fire({
                icon: 'error',
                title: 'Please enter the price of the given plan'
            });
        }
        else if (features == '' || features == 'undefined') {
            Toast.fire({
                icon: 'error',
                title: 'Please add atleast one feature'
            });
        }
        else {
            isValidated = true;
        }
    }
    else {
        isValidated = true;
    }

    if (isValidated) {
        var dataTarget = $('#plan_form').attr('data-action');
        alert(dataTarget);
        if (dataTarget !== '' && dataTarget !== 'undefined') {

            var payLoad = {};
            if (withPlan) {
                payLoad = { 'planId': $('#plan').val(), 'heading': $('#heading').val(), 'price': $('#price').val(), 'features': features, 'page_indentifier': $('#page_indentifier').val(), 'withPlan': withPlan }
            }
            else {
                payLoad = { 'heading': $('#heading').val(), 'withPlan': withPlan, 'page_indentifier': $('#page_indentifier').val() };
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(payLoad)
            $.ajax({
                type: "POST",
                url: dataTarget,
                data: payLoad,
                dataType: "json",
                beforeSend: function () {
                    $('#spinner-loader').fadeIn(100);
                    $('#spinner-loader-text').html('Creating...');
                },
                success: function (response) {

                    if (response.data.response.key == 'success') {

                        if (response.data.plans !== '' && response.data.plans !== 'undefined') {
                            $('#plan_data').val(JSON.stringify(response.data.plans));
                            Toast.fire({
                                icon: 'success',
                                title: response.data.response.message !== '' || response.data.response.message !== 'undefined' ? response.data.response.message : 'Success'
                            })
                        }
                        else {
                            Toast.fire({
                                icon: 'success',
                                title: 'Success'
                            })
                        }

                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: response.data.response.message !== '' || response.data.response.message !== 'undefined' ? response.data.response.message : 'Something went wrong. Try again later'
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
        else {
            Toast.fire({
                icon: 'error',
                title: 'This action is not permitted'
            })
        }
    }

}

function updatePlan() {
    
    var plan = $('#plan').val();
    var withPlan = false;
    var isValidated = false;

    if (plan !== '' && plan !== 'undefined') {

        withPlan = true;
    }

    if ($('#heading').val() == '' || $('#heading').val() == 'undefined') {
        Toast.fire({
            icon: 'error',
            title: 'Please enter page heading'
        });
    }

    else if (withPlan) {
        isValidated = false;
        var features = $('input[name^=features]').map(function (idx, elem) {
            if ($(elem).val().trim() !== '' && $(elem).val().trim() !== 'undefined') {
                return $(elem).val();
            }
        }).get();

        if ($('#plan').val() == '' || $('#plan').val() == 'undefined') {
            Toast.fire({
                icon: 'error',
                title: 'Please select a plan'
            });
        }
        else if ($('#price').val() == '' || $('#price').val() == 'undefined') {
            Toast.fire({
                icon: 'error',
                title: 'Please enter the price of the given plan'
            });
        }
        else if (features == '' || features == 'undefined') {
            Toast.fire({
                icon: 'error',
                title: 'Please add atleast one feature'
            });
        }
        else {
            isValidated = true;
        }
    }
    else {
        isValidated = true;
    }

    if (isValidated) {
        var dataTarget = $('#plan_form').attr('data-action');

        if (dataTarget !== '' && dataTarget !== 'undefined') {

            var payLoad = {};
            if (withPlan) {
                payLoad = { 'planId': $('#plan').val(), '_method': 'PUT', 'heading': $('#heading').val(), 'price': $('#price').val(), 'features': features, 'page_indentifier': $('#page_indentifier').val(), 'withPlan': withPlan }
            }
            else {
                payLoad = { 'heading': $('#heading').val(), '_method': 'PUT' ,'withPlan': withPlan, 'page_indentifier': $('#page_indentifier').val() };
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(payLoad)
            $.ajax({
                type: "POST",
                url: dataTarget,
                data: payLoad,
                dataType: "json",
                beforeSend: function () {
                    $('#spinner-loader').fadeIn(100);
                    $('#spinner-loader-text').html('Creating...');
                },
                success: function (response) {

                    if (response.data.response.key == 'success') {

                        if (response.data.plans !== '' && response.data.plans !== 'undefined') {
                            $('#plan_data').val(JSON.stringify(response.data.plans));
                            Toast.fire({
                                icon: 'success',
                                title: response.data.response.message !== '' || response.data.response.message !== 'undefined' ? response.data.response.message : 'Success'
                            })
                        }
                        else {
                            Toast.fire({
                                icon: 'success',
                                title: 'Success'
                            })
                        }

                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: response.data.response.message !== '' || response.data.response.message !== 'undefined' ? response.data.response.message : 'Something went wrong. Try again later'
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
        else {
            Toast.fire({
                icon: 'error',
                title: 'This action is not permitted'
            })
        }
    }
}
