
function deleteNotification(id) {
    jQuery(function() {
        $.ajax({
            type: "POST",
            url: "/u/deleteNotification",
            data: { id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            beforeSend:function(){
                toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: "toast-top-center",
                preventDuplicates: true,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "3000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
                };

                Command: toastr["success"]( 
                "Deleting..."
                );
            },
            success: function(data) {
                
                $("#notify" + id).fadeOut();
            },
            error: function(data) {
                console.log("Error:", data);
            }
        });
    });
}

function deleteAllNotification() {
    jQuery(function() {
        var ans = window.confirm(
            "Are you sure you want to delete all notifications ? "
        );
        if (ans) {
            $.ajax({
                type: "POST",
                url: "/u/deleteAllNotification",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    window.location.reload();
                },
                error: function(data) {
                    console.log("Error:", data);
                }
            });
        }
    });
}
