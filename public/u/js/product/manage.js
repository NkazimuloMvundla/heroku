function sendId(id) {
    $(document).ready(function() {
        var res = confirm("Are you sure you want to delete this product ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/deleteSingleProduct",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $(".message").text("Deleting...");
                    window.location.reload();
                },
                error: function(data) {
                    console.log("Error", data);
                }
            });
        } else {
            return res;
        }
    });
}

function checkedAll() {
    var check = $('input[name="pd_id[]"]:checked').length;
    if (check > 0) {
        $(document).ready(function() {
            var res = confirm(" Are you sure you want to delete ? ");
            if (res) {
                var notChecked = [],
                    checked = [];
                $("input:checkbox").map(function() {
                    this.checked
                        ? checked.push(this.id)
                        : notChecked.push(this.id);
                });
                console.log("Checked " + checked);
                console.log("Not checked " + notChecked);

                $.ajax({
                    type: "POST",
                    url: "/u/destroyMultipleProduct",
                    data: { checked: checked },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    success: function(data) {
                        $(".message").text("Deleting...");
                        window.location.reload();
                    },
                    error: function(data) {
                        console.log("Error", data);
                    }
                });
            } else {
                return false;
            }
        });
    } else {
        alert("Please check atleast one ");
    }
}
