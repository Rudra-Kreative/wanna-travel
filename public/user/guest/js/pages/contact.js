$(document).on("click", "#enquiryButton", function () {
    var fname = $("#fname").val().trim();
    var lname = $("#lname").val().trim();
    var email = $("#email").val().trim();
    var subject = $("#subject").val().trim();
    var enquery = $("#message").val().trim();
    var emailRegx =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (fname == "" || fname == undefined) {
        Toast.fire({
            icon: "error",
            title: "Enter your first name",
            // position: "bottom-end",
            // timer:500000000000
        });
    } else if (lname == "" || lname == undefined) {
        Toast.fire({
            icon: "error",
            title: "Enter your last name",
            // position: "bottom-end",
        });
    } else if (email == "" || email == undefined || !emailRegx.test(email)) {
        Toast.fire({
            icon: "error",
            title: "Enter an valid email address",
            // position: "bottom-end",
        });
    } else if (subject == "" || subject == undefined) {
        Toast.fire({
            icon: "error",
            title: "Enter a subject",
            // position: "bottom-end",
        });
    } else if (enquery == "" || enquery == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter message",
            // position: "bottom-end",
        });
    } else {
        var dataTarget = $("#enquiry-form").attr("data-action");
        
        if (dataTarget !== "" && dataTarget !== undefined) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: dataTarget,
                data: {
                    fname: fname,
                    lname: lname,
                    email: email,
                    subject: subject,
                    enquery: enquery,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#spinner-loader").fadeIn(100);
                    $("#spinner-loader-text").html("Submitting...");
                },
                success: function (response) {
                    if (response.key == "success") {
                        Toast.fire({
                            icon: "success",
                            title: response.msg,
                            position: "bottom-end",
                        });

                        $("#enquiry-form")[0].reset();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.msg ?? "Something went wrong",
                            position: "bottom-end",
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
                            position: "bottom-end",
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
