function deleteNotification(id) {
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "/u/deleteNotification",
            data: { id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
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
    $(document).ready(function() {
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
