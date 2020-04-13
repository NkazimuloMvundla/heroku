function addSpecFields() {
    $("#add-spec").show();
    $("#add_field_button").show();
    var max_fields = 4; //maximum input boxes allowed
    var x = 1; //initlal text box count

    $("#add_field_button").click(function(e) {
        e.preventDefault();
        if (x <= max_fields) {
            //max input box allowed
            var html = "";
            html += "<tr>";
            html +=
                '<td><input type="text" name="spec_name" id="add_spec_parent"  class="form-control spec_name" placeholder="eg Color" /></td>';
            html +=
                '<td><input type="text" name="spec_option_name" id="add_spec"  class="form-control spec_option_name" placeholder="red" /></td>';
            html +=
                '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
            $("#data-2").append(html);
            x++; //counter increments
        }
        // x++; // putting this here makes sure that the append error dont happen, where it appends more than max
    });

    $("#mc_id").change(function() {
        $("#data-2").html(html);
    });

    $(document).on("click", ".remove", function() {
        $(this)
            .closest("tr")
            .remove();
        x--;
    });
}

function showCat(id) {
    $.ajax({
        type: "POST",
        url: "/subcats",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            //console.log(data);
            var select =
                '<select class="form-control" name="Category" onChange="showSubCat(this.value), changeS();" id="Category">';
            select += "<option>" + "Select" + "</option>" + "<br>";
            for (var i = 0; i < data.length; i++) {
                //  console.log(data[i].pc_)

                select +=
                    '<option value="' +
                    data[i].id +
                    '" >' +
                    data[i].pc_name +
                    "</option>" +
                    "<br>";
                //$("#coin").html("Judge"
            }
            select += "</select";

            $("#coin").html(select);

            //      console.log(data);
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
}

function showSubCat(id) {
    $.ajax({
        type: "POST",
        url: "/lastcats",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            //console.log(data);
            var select =
                '<select class="form-control" name="subCategory" onchange="show_list(), addSpecFields(),getId(this.value);"  id="subCategory">';
            select +=
                "<option selected>" +
                "Select SubCategory" +
                "</option>" +
                "<br>";
            for (var i = 0; i < data.length; i++) {
                //  console.log(data[i].pc_)

                select +=
                    '<option value="' +
                    data[i].id +
                    '" >' +
                    data[i].pc_name +
                    "</option>" +
                    "<br>";
            }
            select += "</select";

            $("#last").html(select);

            //      console.log(data);
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
}

function show_list() {
    var subcateid = $("#subCategory").val();

    $.ajax({
        type: "POST",
        url: "/u/showSpecList",
        data: { subcateid: subcateid },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            var table = '<table class="table table-hover table-striped">';
            table += "<tbody>";

            for (var i = 0; i < data.length; i++) {
                $id = data[i].id;

                table += "<tr>";
                table += "<td>" + data[i].spec_name + "</td>";
                table +=
                    "<td>" +
                    '<input type="text" id="spec_option"  value="" data-value="' +
                    data[i].spec_id +
                    '" class="form-control"  name="spec_option[]">' +
                    "</td>";

                table += "</tr>";
            }
            table += "</tbody>";
            table += "</table>";
            $("#data").html(table);
        }
    });
}

//make sure when the category is changed, the data-2 div is refreshed wih empty content
function changeS() {
    $("#Category").change(function() {
        $("#data-2").html("");
    });
}

function display() {
    $("#data-2").show();
}

function deleteProductImg(id) {
    $(document).ready(function() {
        var res = confirm(" Are you sure you want to delete ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/delete-product-image",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    });
}

function deleteCompanyImg(id) {
    $(document).ready(function() {
        var res = confirm(" Are you sure you want to delete company image? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/delete-company-image",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    });
}
function deleteSpec(id) {
    $(document).ready(function() {
        var res = confirm(" Are you sure you want to delete ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/product/deleteSpecs",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    });
}

function getId(val) {
    var html = "";
    html += '<input type="hidden" value="' + val + '" id="sub">';
    $("#subs").html(html);
}
function updateSpec(id) {
    var specP, specC, stringIds, stringName;
    var specParentIds = [],
        spec_option = [];

    if ($("#sub").val() != "" || $("#sub").val() != "undefined") {
        var sub = $("#sub").val();
    }
    $("input[id='spec_option']").each(function() {
        if (this.value != "") {
            specParentIds.push($(this).data("value"));
            spec_option.push(this.value);
        }
    });
    stringIds = specParentIds.toString();
    stringName = spec_option.toString();

    //user generated spec
    var specParent = [];
    $("input[id='add_spec_parent']").each(function() {
        if (this.value != "") {
            specParent.push(this.value);
        }
    });

    specP = specParent.toString();

    var specChild = [];
    $("input[id='add_spec']").each(function() {
        if (this.value != "") {
            specChild.push(this.value);
        }
    });

    specC = specChild.toString();

    if (specP != "" && specC != "" && stringIds != "" && stringName != "") {
        $.ajax({
            type: "POST",
            url: "/u/product/updateSpecs",
            data: {
                id: id,
                sub: sub,
                specP: specP,
                specC: specC,
                stringIds: stringIds,
                stringName: stringName
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                window.location.reload();
            }
        });
    } else if (specP != "" && specC != "") {
        $.ajax({
            type: "POST",
            url: "/u/product/updateSpecs",
            data: { id: id, sub: sub, specP: specP, specC: specC },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                window.location.reload();
            }
        });
    } else if (stringIds && stringName) {
        $.ajax({
            type: "POST",
            url: "/u/product/updateSpecs",
            data: {
                id: id,
                sub: sub,
                stringIds: stringIds,
                stringName: stringName
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                window.location.reload();
            }
        });
    }
}

function showSpec(id) {
    $.ajax({
        type: "GET",
        url: "/u/product/showSpec",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                $id = data[i].id;
                $spec_option_name = data[i].spec_option_name;
                $spec_parent_id = data[i].spec_parent_id;
            }
            $("#modal-spec-id").text($id);

            $("#parentOfSpec").text($spec_parent_id);
            $("#spec_details").val($spec_option_name);
        }
    });
}

function addSpec() {
    var spec_option_name = $("#spec_details").val();
    var id = $("#modal-spec-id").html();
    $.ajax({
        type: "POST",
        url: "/u/product/addSpec",
        data: { id: id, spec_option_name: spec_option_name },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            window.location.reload();
        }
    });
}
