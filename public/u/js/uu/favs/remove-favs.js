function removeProduct(id) {
    $.ajax({
        type: "POST",
        url: "/u/remove-favorite",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            window.location.reload();
        }
    });
}
