// Add new series ajax
$("#modalBtnSave").click(function(event) {
    event.preventDefault();
    var form = $("#modalBody form"),
        url = form.attr("action"),
        method = $("input[name=_method]").val() == undefined ? "POST" : "PUT";

    var formData = new FormData(form[0]);

    if (method == "PUT") {
        formData.append("_method", "PATCH");
    }

    form.find(".form-text").remove();
    form.find(".form-group").removeClass("has-error");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        method: "POST",
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            form.trigger("reset");
            $("#modalLarge").modal("hide");
            Swal.fire({
                position: "Center",
                icon: "success",
                title: "Yes Saved",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        },
        error: function(xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function(key, value) {
                    $("#" + key)
                        .closest(".form-control")
                        .addClass("is-invalid")
                        .after(
                            '<small class="error invalid-feedback">' +
                                value +
                                "</small>"
                        );
                });
                console.log(xhr);
            }
        }
    });
});
