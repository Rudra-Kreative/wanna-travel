$(document).ready(function () {
    $('#hotel_type_table').DataTable({ "order": [] });
});

//create
$(document).on('click', '#hotel_type_create', function () {
    $('#hotel_type_form_div').slideToggle();
    $(this).text($(this).text() == 'Create' ? 'Close' : 'Create');
});

$(document).on("click", ".editHotelType", function () {
    //var thisType = $(this).closest("td").attr("data-propertyTypeId");
    var thisDataTargetURI = $(this).closest("tr").attr("data-edit-target");
    if (thisDataTargetURI !== "" && thisDataTargetURI !== undefined) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "GET",
            url: thisDataTargetURI,
            data: {},
            dataType: "json",
            beforeSend: function () {
                $("#spinner-loader").fadeIn(100);
                $("#spinner-loader-text").html("Fetching...");
            },
            success: function (response) {
                if (response.res.key == "success" && response.data !== "") {
                    Toast.fire({
                        icon: "success",
                        title: response.res.msg,
                    });
                    $("#edit_name").val(response.data.name);
                    $("#edit_desc").val(response.data.desc);
                    $("#hotel_type_edit_form").attr(
                        "data-actionURI",
                        thisDataTargetURI
                    );
                    $('.editModal').modal('show');
                    
                } else {
                    Toast.fire({
                        icon: "fail",
                        title: response.res.msg,
                    });
                }
            },
            error: function (request, status, error) {
                responses = jQuery.parseJSON(request.responseText);

                if (responses.errors) {
                    var errorHtml = "<ul>";
                    $.each(responses.errors, function (key, value) {
                        errorHtml += "<li>" + value + "</li>";
                    });
                    errorHtml += "</ul>";

                    Toast.fire({
                        icon: "error",
                        title: errorHtml,
                    });
                }
            },
            complete: function () {
                $("#spinner-loader").fadeOut(100);
            },
        });
    }
});

$(".editModal").on('hide.bs.modal', function () {
    $("#hotel_type_edit_form")[0].reset();
    $("#hotel_type_edit_form").attr("data-actionURI", "");
});

$(document).on('click','.updateHotelType',function () { 
    var name =  $("#edit_name").val();
    var desc =  $("#edit_desc").val();

    if(name == '' || name == undefined)
    {
        Toast.fire({
            icon: "error",
            title: "Please enter hotel type name",
        });
    }

    else if(desc == '' || desc == undefined)
    {
        Toast.fire({
            icon: "error",
            title: "Please enter some description about the hotel type",
        });
    }
    else
    {
        var thisDataTargetURI = $('#hotel_type_edit_form').attr('data-actionURI');
        if(thisDataTargetURI !== '' && thisDataTargetURI !==undefined)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: thisDataTargetURI,
                data: {'name':name,'desc':desc,'_method':'put'},
                dataType: "json",
                beforeSend: function () {
                    $('#spinner-loader').fadeIn(100);
                    $('#spinner-loader-text').html('Updating...');
                },
                success: function (response) {
                    if(response.res.key !== undefined && response.res.key == 'success' && response.data.length > 0)
                    {
                        tableBody = prepareHotelTypeRTable(response.data);
                        $('#hotel_type_body').html(tableBody);
                        $("#hotel_type_table").DataTable();
                        $('.closeEditModal').trigger('click');
                        Toast.fire({
                            icon: "success",
                            title: response.res.msg,
                        });
                    }
                    else
                    {
                        Toast.fire({
                            icon: "error",
                            title: response.res.msg,
                        });
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
 });

 $(document).on('click','.deleteHotelType',function () { 

    Swal.fire({
        title: 'Are you sure to delete this hotel type?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {
            
            var thisDataTargetURI = $(this).closest("tr").attr("data-delete-target");
            alert(thisDataTargetURI)
    if(thisDataTargetURI !== '' && thisDataTargetURI !== undefined){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: thisDataTargetURI,
            data: {'_method':'delete'},
            dataType: "json",
            beforeSend: function () {
                $('#spinner-loader').fadeIn(100);
                $('#spinner-loader-text').html('Deleting...');
            },
            success: function (response) {
                if(response.res.key !== undefined && response.res.key == 'success' && response.data.length > 0)
                {
                    tableBody = prepareHotelTypeRTable(response.data);
                    $('#hotel_type_body').html(tableBody);
                    $("#hotel_type_table").DataTable();
                    $('.closeEditModal').trigger('click');
                    Toast.fire({
                        icon: "success",
                        title: response.res.msg,
                    });
                }
                else
                {
                    Toast.fire({
                        icon: "error",
                        title: response.res.msg,
                    });
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

    })

    
    
 });

 function prepareHotelTypeRTable(data)
{
    tableBody = '';
    $.each(data, function (k, v) {

        tableBody += "<tr data-edit-target='../hotel/type/"+v.id+"/edit' data-delete-target='../hotel/type/"+v.id+"/delete'>";
        tableBody += "<td ><p>" + v.name + "</p></td>";

        tableBody += "<td>" + v.desc + "</td>";

        tableBody += "<td data-hotelTypeId='" + v.id + "'>";
        tableBody += "<i class='fa fa-trash deleteHotelType' title='Delete'  style='margin-right: 5px;cursor: pointer;' aria-hidden='true'></i>";
        tableBody += '<i class="fa fa-edit editHotelType" title="Edit" style="cursor: pointer;margin-right: 5px" aria-hidden="true"></i>';
        //tableBody += '<i class="fa fa-ban supendPropertyType" title="Suspend" style="cursor: pointer" aria-hidden="true"></i>';
        tableBody += "</td></tr>";
    });

    return tableBody;
}