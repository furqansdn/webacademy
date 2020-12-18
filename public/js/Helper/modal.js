$("body").on("click", ".modal-show", function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title");

    $("#modalTitle").text(title);
    $("#modalBtnSave").show();

    $.ajax({
        url: url,
        dataType: "html",
        success: function(response) {
            $("#modalBody").html(response);
        }
    });

    $("#modalLarge").modal("show");
});

$("body").on("click", ".modal-delete", function(event) {
    event.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        const url = $(this).attr("href");
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $.ajax({
                type: "DELETE",
                url: url,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        position: "Center",
                        icon: "success",
                        title: "Deleted",
                        text: "Anda berhasil menghapus data",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    });
});
