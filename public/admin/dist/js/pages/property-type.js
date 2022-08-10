//create
$(document).on("click", "#property_type_create", function () {
    $("#property_type_form_div").slideToggle();
    $(this).text($(this).text() == "Create" ? "Close" : "Create");
});

$(document).ready(function () {
    $("#property_type_table").DataTable({ order: [] });
    $("#multiselect").multiselect();
});

$(document).on("click", ".editPropertyType", function () {
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
                    var selectedHotelTypeHtml = "";

                    $.each(
                        response.data.propertyType.hotel_type,
                        function (key, val) {
                            selectedHotelTypeHtml +=
                                "<option value='" +
                                val.id +
                                "' >" +
                                val.name +
                                "</option>";
                        }
                    );

                    $("#edit_name").val(response.data.propertyType.name);
                    $(".edit_hotelTypes").html(selectedHotelTypeHtml);
                    $("#edit_desc").val(response.data.propertyType.desc);
                    $("#edit_property_image_preview").html(
                        "<div class='col-md-4'><img class='rounded previewImg' style='width: 100%; height:200px' src='/" +
                            response.data.propertyType.avatar +
                            "'></div>"
                    );
                    var allHotelTypeData = jQuery.parseJSON(
                        $("#allHotelTypesData").val()
                    );
                    $.each(allHotelTypeData, function (k, v) {
                        $("#multiselect_to_edit option[value='" + v.id + "']")
                            .length > 0
                            ? $(
                                  "#multiselect_edit option[value='" +
                                      v.id +
                                      "']"
                              ).remove()
                            : "";
                    });
                    $("#multiselect_edit").multiselect({
                        right: "#multiselect_to_edit",
                        rightSelected: "#multiselect_rightSelected_edit",
                        rightAll: "#multiselect_rightAll_edit",
                        leftSelected: "#multiselect_leftSelected_edit",
                        leftAll: "#multiselect_leftAll_edit",
                    });
                    $("#edit_property_image_preview_sec").fadeIn(100);
                    $("#property_edit_form").attr(
                        "data-actionURI",
                        thisDataTargetURI
                    );
                    $(".editModal").modal("show");
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

$(".editModal").on("hide.bs.modal", function () {
    var allHotelTypeData = jQuery.parseJSON($("#allHotelTypesData").val());
    var allHotelTypeHtml = "";

    $.each(allHotelTypeData, function (k, v) {
        allHotelTypeHtml +=
            "<option value='" + v.id + "' >" + v.name + "</option>";
    });
    $("#multiselect_edit").html(allHotelTypeHtml);
    $("#property_edit_form")[0].reset();
    $("#edit_property_image_preview").html("");
    $("#property_edit_form").attr("data-actionURI", "");
    $("#edit_property_image_preview_sec").fadeOut(100);
});

$(document).on("click", ".updateProperty", function () {
    var name = $("#edit_name").val();
    var desc = $("#edit_desc").val();
    var selecetedHotelTypes = [];
    $(".edit_hotelTypes option").each(function () {
        selecetedHotelTypes.push($(this).val());
    });
    if (name == "" || name == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter property name",
        });
    } else if (desc == "" || desc == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter some description about the property",
        });
    } else if (
        selecetedHotelTypes == "" ||
        selecetedHotelTypes == undefined ||
        selecetedHotelTypes.length <= 0
    ) {
        Toast.fire({
            icon: "error",
            title: "Please select atleast one hotel type",
        });
    } else {
        var formData = new FormData();
        var this_img = document.getElementById("edit_avatar");
        if (this_img.files.length > 0) {
            formData.append("avatar", this_img.files[0]);
        }
        formData.append("name", name);
        formData.append("desc", desc);
        formData.append("hotelTypes", selecetedHotelTypes);
        formData.append("_method", "put");

        var thisDataTargetURI = $("#property_edit_form").attr("data-actionURI");

        if (thisDataTargetURI !== "" && thisDataTargetURI !== undefined) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: thisDataTargetURI,
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#spinner-loader").fadeIn(100);
                    $("#spinner-loader-text").html("Updating...");
                },
                success: function (response) {
                    if (
                        response.res.key !== undefined &&
                        response.res.key == "success" &&
                        response.data.length > 0
                    ) {
                        tableBody = preparePropertyTypeRTable(response.data);
                        $("#property_type_body").html(tableBody);
                        $("#property_type_table").DataTable();
                        $(".closeEditModal").trigger("click");
                        Toast.fire({
                            icon: "success",
                            title: response.res.msg,
                        });
                    } else {
                        Toast.fire({
                            icon: "error",
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
    }
});

$(document).on("click", ".deletePropertyType", function () {
    Swal.fire({
        title: "Are you sure to delete this property type?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            var thisDataTargetURI = $(this)
                .closest("tr")
                .attr("data-delete-target");

            if (thisDataTargetURI !== "" && thisDataTargetURI !== undefined) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });

                $.ajax({
                    type: "POST",
                    url: thisDataTargetURI,
                    data: { _method: "delete" },
                    dataType: "json",
                    beforeSend: function () {
                        $("#spinner-loader").fadeIn(100);
                        $("#spinner-loader-text").html("Deleting...");
                    },
                    success: function (response) {
                        if (
                            response.res.key !== undefined &&
                            response.res.key == "success" &&
                            response.data.length > 0
                        ) {
                            tableBody = preparePropertyTypeRTable(
                                response.data
                            );
                            $("#property_type_body").html(tableBody);
                            $("#property_type_table").DataTable();
                            $(".closeEditModal").trigger("click");
                            Toast.fire({
                                icon: "success",
                                title: response.res.msg,
                            });
                        } else {
                            Toast.fire({
                                icon: "error",
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
        }
    });
});

function preparePropertyTypeRTable(data) {
    tableBody = "";
    $.each(data, function (k, v) {
        tableBody +=
            "<tr data-edit-target='../hotel/property/" +
            v.id +
            "/edit' data-delete-target='../hotel/property/" +
            v.id +
            "/delete'>";
        tableBody +=
            "<td style='text-align:center'>" +
            "<img class='rounded-circle' style='width: 50px;height: 50px;' src='" +
            (v.avatar != "" && v.avatar != null
                ? "/" + v.avatar
                : "https://i.pravatar.cc/50?u=" + v.id) +
            "' alt=''></img><p>" +
            v.name +
            "</p></td>";

        tableBody += "<td>" + v.desc + "</td>";
        tableBody += "<td>";
        $.each(v.hotel_type, function (key, val) {
            tableBody +=
                '<span class="badge badge-primary">' + val.name + "</span>";
        });
        tableBody += "</td>";
        tableBody += "<td data-propertyTypeId='" + v.id + "'>";
        tableBody +=
            "<i class='fa fa-trash deletePropertyType' title='Delete'  style='margin-right: 5px;cursor: pointer;' aria-hidden='true'></i>";
        tableBody +=
            '<i class="fa fa-edit editPropertyType" title="Edit" style="cursor: pointer;margin-right: 5px" aria-hidden="true"></i>';
        //tableBody += '<i class="fa fa-ban supendPropertyType" title="Suspend" style="cursor: pointer" aria-hidden="true"></i>';
        tableBody += "</td></tr>";
    });

    return tableBody;
}

function previewImages(src, dest, showSec = "") {
    var total_file = document.getElementById(src).files.length;
    // Allowing file type
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.bmp|\.webp)$/i;
    if (!allowedExtensions.exec($("#" + src).val())) {
        Toast.fire({
            icon: "error",
            title: "This file type is not supported",
        });
        $("#" + src).val("");
        $("#" + dest).html("");
        $("#" + showSec).fadeOut(600);
        return false;
    }

    var appendHtml = "<div class='row'>";

    for (let index = 0; index < total_file; index++) {
        appendHtml +=
            "<div class='col-md-4'><img class='rounded previewImg' style='width: 100%; height:200px' src='" +
            URL.createObjectURL(event.target.files[index]) +
            "'></div>";
    }
    $("#" + dest).html(appendHtml + "</div>");
    if (total_file > 0) {
        $("#" + showSec).fadeIn(600);
    } else {
        $("#" + showSec).fadeOut(600);
    }
}
