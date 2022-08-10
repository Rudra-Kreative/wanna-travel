$(document).ready(function () {
    $('#hotel_table').DataTable({ "order": [] });
});

//create
$(document).on("click", "#hotel_create", function () {
    $("#hotel_form_div").slideToggle();
    $(this).text($(this).text() == "Create" ? "Close" : "Create");
});

$(document).on("change", "#property_type", function () {
    var thisProperty = $(this).val();
    if (thisProperty !== "" && thisProperty !== undefined) {
        var propertyData = $("#property_data").val();
        propertyData =
            propertyData !== "" && propertyData !== undefined
                ? JSON.parse(propertyData)
                : "";

        if (propertyData !== "" && propertyData !== undefined) {
            $.each(propertyData, function (index, val) {
                if (val.id == thisProperty) {
                    if (val.hotel_type !== "" && val.hotel_type !== undefined) {
                        appendableHtml = '<div class="select2-purple">';
                        appendableHtml += '<select class="select2" multiple="multiple" name="hotel_type[]" data-placeholder="Select your hotel type" data-dropdown-css-class="select2-purple" style="width: 100%;">';
                        $.each(val.hotel_type, function (i, v) {
                            
                            appendableHtml +=
                                '<option value="'+v.id+'" >"'+v.name+'"</option>';
                                
                        });
                        appendableHtml+='</select></div>';
                        
                        $(".hotelTypeDivSec").html(appendableHtml);
                        $('.select2').select2();
                        $(".hotelTypeDiv").fadeIn(500);
                    }
                }
            });
        }
    } else {
        $(".hotelTypeDivSec").html('');
        $(".hotelTypeDiv").fadeOut(500);
        return false;
    }
});

$(document).on('click','.viewAllImages',function () { 
    var thisHotelId = $(this).attr('data-hotelId');
    var thisDataTargetURI = $(this).attr('data-targetURI');
    if((thisHotelId !== '' && thisHotelId !== undefined) && (thisDataTargetURI !== '' && thisDataTargetURI !== undefined))
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: thisDataTargetURI,
            data: {},
            dataType: "json",
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Fetching...');
            },
            success: function (response) {
                if (response.res.key == 'success') {

                    if (response.data !== '' && response.data !== 'undefined') {
                        appendHtml = '<div class="row">';
                        $.each(response.data, function (index, val) { 
                             appendHtml += '<div style="margin: 0 0 15px 0;" class="col-md-4"><img src="/'+val.image+'" class="rounded" style="width: 100%;height:100%" /></div>'
                        });
                        $('.hotelImageGalleryBody').html(appendHtml+'</div>');
                        $('.hotelImageGalleryModal').modal('show');
                        Toast.fire({
                            icon: 'success',
                            title: response.res.message !== '' || response.res.message !== 'undefined' ? response.res.message : 'Success'
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
                        title: response.res.message !== '' || response.res.message !== 'undefined' ? response.res.message : 'Something went wrong. Try again later'
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
    else
    {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong'
        })
    }
 })

 $(document).on('click','.viewHotelDetails',function(){
    var thisHotelId = $(this).closest('td').attr('data-hotelId');
    var thisDataTargetURI = $(this).attr('data-targetURI');
    if((thisHotelId !== '' && thisHotelId !== undefined) && (thisDataTargetURI !== '' && thisDataTargetURI !== undefined))
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: thisDataTargetURI,
            data: {},
            dataType: "json",
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Fetching...');
            },
            success: function (response) {
                if (response.res.key == 'success') {

                    if (response.data !== '' && response.data !== 'undefined') {
                        //console.log(data);
                        $('.hotelName,#detail_name').html(response.data.name ?? '');
                        $('#detail_ownerName').html(response.data.contact_name ?? '');
                        
                        if(response.data.creatable_type !== '' && response.data.creatable_type != undefined)
                        {
                            if(response.data.creatable_type == 'App\\Models\\Administrator')
                            {
                                $('#creatable_type').html('Admin');
                            }
                            else if(response.data.creatable_type == 'App\\Models\\User')
                            {
                                $('#creatable_type').html(response.data.creatable.name ?? 'User');
                            }
                        }
                        $('#detail_phone').html(response.data.phone ?? '');
                        $('#detail_phone').append(response.data.alternate_phone ? '/'+response.data.alternate_phone : '');
                        $('#detail_address').html(response.data.address ?? '');
                        $('#detail_alternate_address').html(response.data.alternate_address ?? '');
                        // $('.modal-body').html(appendHtml+'</div>');
                         $('.viewHotelModal').modal('show');
                        Toast.fire({
                            icon: 'success',
                            title: response.res.msg !== '' || response.res.msg !== 'undefined' ? response.res.msg : 'Success'
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
                        title: response.res.msg !== '' || response.res.msg !== 'undefined' ? response.res.msg : 'Something went wrong. Try again later'
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
    else
    {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong'
        })
    }
 });


function previewHotelImages() {
    var total_file = document.getElementById("avatars").files.length;

    var appendHtml = "<div class='row'>";

    for (let index = 0; index < total_file; index++) {
        appendHtml +=
            "<div class='col-md-4'><img class='rounded previewImg' style='weight: 200px;height:200px' src='" +
            URL.createObjectURL(event.target.files[index]) +
            "'></div>";

        $("#avatar_preview").html(appendHtml+'</div>');
    }
    if (total_file > 0) {
        $("#avatar_preview_sec").fadeIn(600);
    } else {
        $("#avatar_preview_sec").fadeOut(600);
    }
}
