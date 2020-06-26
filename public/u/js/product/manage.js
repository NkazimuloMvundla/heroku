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
                //console.log("Checked " + checked);
                // console.log("Not checked " + notChecked);

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

/*=============manage-b-req=============*/
//  append values in input fields
$(document).on("click", "a[data-role=update]", function() {
    var id = $(this).data("id");
    var br_pd_spec = $("#" + id)
        .children("td[data-target=br_pd_spec]")
        .text();

    $("#br_pd_spec").val(br_pd_spec);
    $("#userId").val(id);

    $("#modal-default").modal("toggle");
});

$("#save").click(function() {
    var id = $("#userId").val();
    var br_pd_spec = $("#br_pd_spec").val();
    if (br_pd_spec == "") {
        alert("This cannot be empty");
    } else {
        $.ajax({
            url: "/u/update-buying-request",
            method: "POST",
            data: { br_pd_spec: br_pd_spec, id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                // now update user record in table
                $("#" + id)
                    .children("td[data-target=br_pd_spec]")
                    .text(br_pd_spec);

                $("#modal-default").modal("toggle");
            },
            error: function(data) {
                console.log("Error:", data);
            }
        });
    }
});

function deleteSellingRequest(id) {
    $(document).ready(function() {
        var res = confirm(" Are you sure you want to delete ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/delete-selling-request",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $(".message").text("Deleting...");
                    window.location.reload();
                },
                error: function(data) {
                    console.log("Error:", data);
                }
            });
        }
    });
}

/*==================manage-selling-req=====================*/
//  append values in input fields
$(document).on("click", "a[data-role=update]", function() {
    var id = $(this).data("id");
    var sr_pd_spec = $("#" + id)
        .children("td[data-target=sr_pd_spec]")
        .text();

    $("#sr_pd_spec").val(sr_pd_spec);
    $("#userId").val(id);

    $("#modal-selling").modal("toggle");
});

$("#save-sellingUpdate").click(function() {
    var id = $("#userId").val();
    var sr_pd_spec = $("#sr_pd_spec").val();
    if (sr_pd_spec == "") {
        alert("This cannot be empty");
    } else {
        $.ajax({
            url: "/u/update-selling-request",
            method: "POST",
            data: { sr_pd_spec: sr_pd_spec, id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                // now update user record in table
                $("#" + id)
                    .children("td[data-target=sr_pd_spec]")
                    .text(sr_pd_spec);

                $("#modal-selling").modal("toggle");
            },
            error: function(data) {
                console.log("Error:", data);
            }
        });
    }
});

function deleteRequest(id) {
    $(document).ready(function() {
        var res = confirm(" Are you sure you want to delete ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/delete-buying-request",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $(".message").text("Deleting...");
                    window.location.reload();
                },
                error: function(data) {
                    console.log("Error:", data);
                }
            });
        }
    });
}
