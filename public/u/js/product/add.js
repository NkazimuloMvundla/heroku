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
//make sure when the category is changed, the data-2 div is refreshed wih empty content
function changeS() {
    $("#Category").change(function() {
        $("#data-2").html("");
    });
}

function display() {
    $("#data-2").show();
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
                '<select class="form-control" name="subCategory" onchange="show_list(), addSpecFields();" id="subCategory">';
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
var chekha, stringIds, stringName, specP, specC;

$(".paymentMethod").on("click", function() {
    var notChecked = [],
        checked = [];
    $("input:checkbox").map(function() {
        this.checked ? checked.push(this.id) : notChecked.push(this.id);
    });

    chekha = checked.toString();
});

Dropzone.options.myDropzone = {
    // Dropzone.autoDiscover = false;
    url: "/u/add-new-product",
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 3,
    maxFiles: 3,
    maxFilesize: 1,
    acceptedFiles: "image/*",
    addRemoveLinks: true,

    success: function(responseText, data) {
        //alert(data);
    },

    error: function(file, response) {
        if ($.type(response) === "string") var message = response;
        //dropzone sends it's own error messages in string
        else var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push((node.textContent = message));
        }
        return (document.getElementById(
            "dz-error-message"
        ).textContent = _results);
    },

    init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document
            .getElementById("submitFormBtnA")
            .addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();

                // var Category = jQuery("#Category").val();
                // var subCategory = jQuery("#subCategory").val();
                var Product_Name = jQuery("#Product_Name").val();
                var Product_Keyword = jQuery("#Product_Keyword").val();
                var listing_description = jQuery("#listing_description").val();
                var Minimum_Order_Quantity = jQuery(
                    "#Minimum_Order_Quantity"
                ).val();
                var Minimum_order_unit = jQuery("#Minimum_order_unit").val();
                var Max_price = jQuery("#Max_price").val();
                var Min_price = jQuery("#Min_price").val();
                var Minimum_unit = jQuery("#Minimum_unit").val();
                var Port = jQuery("#Port").val();
                var paymentMethod = jQuery(".Port").val();
                var supplyQuantity = jQuery("#supplyQuantity").val();
                var supplyUnit = jQuery("#supplyUnit").val();
                var supplyPeriod = jQuery("#supplyPeriod").val();
                var deliveryTime = jQuery("#date").val();
                var digitEXP = /^[0-9.]*$/;

                //logic

                //  if($("#add_spec_parent").val() !='' && $("#add_spec").val() =='' ){
                //  $('#add_spec_error').text('Please fill boxes').css("color", "red");

                //  }else if($("#add_spec").val() !='' && $("#add_spec_parent").val() =='' ){
                //   $('#add_spec_error').text('Please fill boxes').css("color", "red");

                //  }else{
                //     $('#add_spec_error').text('');
                //  }

                if ($("#mc_id").val() == "Main category") {
                    $(".main-cats")
                        .text("Please select a main category")
                        .css("color", "red");
                } else {
                    $(".main-cats")
                        .text("")
                        .css("color", "red");
                }
                if ($("#c_id").val() == "Category") {
                    $(".cat")
                        .text("Please select a category")
                        .css({ color: "red" });
                } else {
                    $(".cat").text("");
                }
                if ($("#subCategory").val() == "Sub Category") {
                    $(".sub")
                        .text("Please select a sub category")
                        .css({ color: "red" });
                } else {
                    $(".sub").text("");
                }

                if (Product_Name == "") {
                    $(".product-name")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".product-name").text("");
                }

                if (Product_Keyword == "") {
                    $(".product_keyword")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".product_keyword").text("");
                }

                if (listing_description == "") {
                    $(".listing_description")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".listing_description").text("");
                }

                if (Minimum_Order_Quantity == "") {
                    $(".Minimum_Order_Quantity")
                        .text("This field is required")
                        .css({ color: "red" });
                } else if (isNaN(Minimum_Order_Quantity)) {
                    $(".Minimum_Order_Quantity")
                        .text("This field must be a number")
                        .css({ color: "red" });
                } else {
                    $(".Minimum_Order_Quantity").text("");
                }

                if (Minimum_order_unit == "Choose your option") {
                    $(".Minimum_order_unit")
                        .text("Please select units")
                        .css({ color: "red" });
                } else {
                    $(".Minimum_order_unit").text("");
                }
                if (Min_price == "") {
                    $(".Min_price")
                        .text("This field is required")
                        .css({ color: "red" });
                }
                if (isNaN(Min_price)) {
                    $(".Min_price")
                        .text("This field must be a number")
                        .css({ color: "red" });
                } else {
                    $(".Min_price").text("");
                }

                if (Max_price == "") {
                    $(".Max_price")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".Max_price").text("");
                }
                if (
                    parseFloat(jQuery("#Max_price").val()) <=
                    parseFloat(jQuery("#Min_price").val())
                ) {
                    $(".Max_price")
                        .text("Minimum cannot be greater than Max")
                        .css({ color: "red" });
                    jQuery("#Max_price").val() = "";
                } else {
                    $(".Max_price").text("");
                }

                if (Minimum_unit == "Choose your option") {
                    $(".Minimum_unit")
                        .text("Please select units")
                        .css({ color: "red" });
                } else {
                    $(".Minimum_unit").text("");
                }
                if (Port == "") {
                    $(".Port")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".Port").text("");
                }
                if (!jQuery(".paymentMethod").is(":checked")) {
                    $(".paymentMethod")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".paymentMethod").text("");
                }

                if (supplyQuantity == "") {
                    $(".supplyQuantity")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".supplyQuantity").text("");
                }
                if (supplyUnit == "Choose your option") {
                    $(".supplyUnit")
                        .text("Please select units")
                        .css({ color: "red" });
                } else {
                    $(".supplyUnit").text("");
                }
                if (supplyPeriod == "Select period") {
                    $(".supplyPeriod")
                        .text("Please select period")
                        .css({ color: "red" });
                } else {
                    $(".supplyPeriod").text("");
                }
                if (deliveryTime == "") {
                    $(".deliveryTime")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".deliveryTime").text("");
                }
            });
        this.on("drop", function(file) {
            $("#submitFormBtnA").removeAttr("disabled");
            // $('#dz-error-message').text('');
        });

        this.on("addedfile", function(file) {
            $("#submitFormBtnA").removeAttr("disabled");
            $("#dz-error-message").text("");
        });

        this.on("removedfile", function(file) {
            $("#submitFormBtnA").attr("disabled", "disabled");
            //$('#dz-error-message').text('');
        });

        this.on("success", function(file, responseText) {
            // console.log(responseText);
            if (responseText == "success") {
                alert("Product added");
                window.location = "/u/add-new-product";
            }
            
        });

        this.on("complete", function(file) {
            if (file == "") {
                alert("Please god");
            }
        });

        this.on("error", function(file, data, xhr, responseText) {
            if (xhr.status != 200) {
                this.removeFile(file);
            }
        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("mainCategory", jQuery("#mc_id").val());
            formData.append("Category", jQuery("#Category").val());
            formData.append("subCategory", jQuery("#subCategory").val());
            formData.append("Product_Name", jQuery("#Product_Name").val());
            //speccifications

            var specParentIds = [],
                spec_option = [];

            $("input[id='spec_option']").each(function() {
                if (this.value != "") {
                    specParentIds.push($(this).data("value"));
                    spec_option.push(this.value);
                    stringIds = specParentIds.toString();
                    stringName = spec_option.toString();
                    // console.log(stringName)
                    //console.log(stringIds)
                    formData.append("stringIds", stringIds);
                    formData.append("stringName", stringName);
                }
            });

            //user generated spec
            var specParent = [];
            $("input[id='add_spec_parent']").each(function() {
                if (this.value == "") {
                    $("#add_spec_error")
                        .text("Please fill boxes")
                        .css("color", "red");
                } else {
                    $("#add_spec_error").text("");
                    specParent.push(this.value);
                    specP = specParent.toString();

                    formData.append("specP", specP);
                }
            });

            var specChild = [];
            $("input[id='add_spec']").each(function() {
                if (this.value == "") {
                    $("#add_spec_child_error")
                        .text("Please fill child boxes")
                        .css("color", "red");
                } else {
                    $("#add_spec_child_error").text("");
                    specChild.push(this.value);
                    specC = specChild.toString();

                    formData.append("specC", specC);
                }
            });

            formData.append(
                "Product_Keyword",
                jQuery("#Product_Keyword").val()
            );
            formData.append(
                "listing_description",
                jQuery("#listing_description").val()
            );
            formData.append(
                "Minimum_Order_Quantity",
                jQuery("#Minimum_Order_Quantity").val()
            );
            formData.append(
                "Minimum_order_unit",
                jQuery("#Minimum_order_unit").val()
            );
            formData.append("Max_price", jQuery("#Max_price").val());
            formData.append("Min_price", jQuery("#Min_price").val());
            formData.append("Minimum_unit", jQuery("#Minimum_unit").val());
            formData.append("Port", jQuery("#Port").val());
            formData.append("paymentMethod", chekha);
            formData.append("supplyQuantity", jQuery("#supplyQuantity").val());
            formData.append("supplyUnit", jQuery("#supplyUnit").val());
            formData.append("supplyPeriod", jQuery("#supplyPeriod").val());
            formData.append("deliveryTime", jQuery("#date").val());
        });
    }
};