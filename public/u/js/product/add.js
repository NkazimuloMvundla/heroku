

$(document).ready(function() {
   // $("#add-spec").show();

    var wrapper = $("#data-2")
    var max_fields = 7; //maximum input boxes allowed
    var x = 1; //initlal text box count

    $("#add_field_button").click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
                x++; //counter increments
         $(wrapper).append(
            "<tr class='rem'><td><input type='text' name='spec_name' class='add_spec_parent'  class='form-control spec_name' placeholder='eg Color' /></td><td><input type='text' name='spec_option_name' class='add_spec'  class='form-control spec_option_name' placeholder='red' /></td><td><button type='button' name='remove' class='btn btn-danger btn-sm remove'><span class='glyphicon glyphicon-minus'></span></button></td></tr>"
            );
        }else{
            $(".reachedLimitToAppend").text("You have reached the limit");
        }
    });

    $(document).on("click", ".remove", function() {
        $(this)
            .closest("tr")
            .remove();
        x--;
    });

});

function showBtn(){
  $("#add_field_button").show();
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
            var select =
                '';
            select += "<option>" + "Select" + "</option>" + "<br>";
            for (var i = 0; i < data.length; i++) {

                select +=
                    '<option value="' +
                    data[i].id +
                    '" >' +
                    data[i].pc_name +
                    "</option>" +
                    "<br>";

            }
            $(".coin").html(select);
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
            var select =
                '';
            select +=
                "<option selected>" +
                "Select" +
                "</option>" +
                "<br>";
            for (var i = 0; i < data.length; i++) {
                select +=
                    '<option value="' +
                    data[i].id +
                    '" >' +
                    data[i].pc_name +
                    "</option>" +
                    "<br>";
            }


            $(".last").html(select);

        }
    });
}

$(document).ready(function () {
    $("#last").on('change', function () {
        showCat(this.value);
    })
})



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
    $("input[class='spec_option']").each(function() {
        if (this.value != "") {
            specParentIds.push($(this).data("value"));
            spec_option.push(this.value);
        }
    });
    stringIds = specParentIds.toString();
    stringName = spec_option.toString();

    //user generated spec
    var specParent = [];
    $("input[class='add_spec_parent']").each(function() {
        if (this.value != "") {
            specParent.push(this.value);
        }
    });

    specP = specParent.toString();

    var specChild = [];
    $("input[class='add_spec']").each(function() {
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
        type: "POST",
        url: "/u/product/showSpec",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        beforeSend:function(){
            $("#spec_details").prop('disabled', true).val("Please wait..."); 
        },
        complete:function(){
            $("#spec_details").prop('disabled', false); 
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
    var id = $("#modal-spec-id").text();
    $.ajax({
        type: "POST",
        url: "/u/product/addSpec",
        data: { id: id, spec_option_name: spec_option_name },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            window.location.reload();
        },
        error: function (data) {
            console.log("Err", data)
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
                    '<input type="text" class="spec_option"  data-value="' +
                  data[i].spec_id+
                    '" class="form-control"  name="spec_option[]">' +
                    "</td>";

                table += "</tr>";
            }
            table += "</tbody>";
            table += "</table>";
            $("#data").html(table);
            $("#add-spec").show();
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
    method:"POST",
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 3,
    maxFiles: 3,
    maxFilesize: 1,
    acceptedFiles: "image/*",
    addRemoveLinks: true,

    success: function(responseText, data) {
      //  alert(data);
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

                var Product_Name = jQuery("#Product_Name").val();
                var Product_Keyword = jQuery("#Product_Keyword").val();
                var listing_description = jQuery("#listing_description").val();
                var Minimum_Order_Quantity = jQuery(
                    "#Minimum_Order_Quantity"
                ).val();
                var Minimum_order_unit = jQuery("#Minimum_order_unit").val();
                var Min_price = jQuery("#Min_price").val();
                var Max_price = jQuery("#Max_price").val();
                var Minimum_unit = jQuery("#Minimum_unit").val();
                var Port = jQuery("#Port").val();
                var paymentMethod = jQuery(".paymentMethod").val();
                var supplyQuantity = jQuery("#supplyQuantity").val();
                var supplyUnit = jQuery("#supplyUnit").val();
                var supplyPeriod = jQuery("#supplyPeriod").val();
                var deliveryTime = jQuery("#date").val();
                var digitEXP = /^[0-9.]*$/;

                if ($("#mc_id").val() === "Main category") {
                    $(".main-cats")
                        .text("Please select a main category")
                        .css("color", "red");
                } else {
                    $(".main-cats")
                        .text("")
                        .css("color", "red");
                }
                if ($("#c_id").val() === "Select") {
                    $(".cat")
                        .text("Please select a category")
                        .css({ color: "red" });
                } else {
                    $(".cat").text("");
                }
                if ($("#subCategory").val() === "Select") {
                    $(".sub")
                        .text("Please select a sub category")
                        .css({ color: "red" });
                } else {
                    $(".sub").text("");
                }

                if (Product_Name === "") {
                    $(".product-name")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".product-name").text("");
                }

                if (Product_Keyword === "") {
                    $(".product_keyword")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".product_keyword").text("");
                }

                if (listing_description === "") {
                    $(".listing_description")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".listing_description").text("");
                }

                if (Minimum_Order_Quantity === "") {
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

                if (Minimum_order_unit === "Choose your option") {
                    $(".Minimum_order_unit")
                        .text("Please select units")
                        .css({ color: "red" });
                } else {
                    $(".Minimum_order_unit").text("");
                }

                if (Min_price === "") {
                    $(".Min_price")
                        .text("This field is required")
                        .css({ color: "red" });
                }else if(isNaN(Min_price)){
                      $(".Min_price")
                       .text("This field must be a number")
                       .css({ color: "red" });

                }else{
                      $(".Min_price")
                       .text("")
                }

                if (Max_price === "") {
                       $(".Max_price")
                       .text("This field is required")
                       .css({ color: "red" });
                }else if(isNaN(Max_price)){
                      $(".Max_price")
                       .text("This field must be a number")
                       .css({ color: "red" });
                }
                else if (
                    parseFloat(Max_price) <=
                    parseFloat(Min_price)
                ) {
                    $(".Max_price")
                        .text("Minimum cannot be greater than Max")
                        .css({ color: "red" });
                    jQuery("#Max_price").val() = "";
                } else {
                    $(".Max_price").text("");
                }

                if (Minimum_unit === "Choose your option") {
                    $(".Minimum_unit")
                        .text("Please select units")
                        .css({ color: "red" });
                } else {
                    $(".Minimum_unit").text("");
                }
                if (Port === "") {
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

                if (supplyQuantity === "") {
                    $(".supplyQuantity")
                        .text("This field is required")
                        .css({ color: "red" });
                } else {
                    $(".supplyQuantity").text("");
                }
                if (supplyUnit === "Choose your option") {
                    $(".supplyUnit")
                        .text("Please select units")
                        .css({ color: "red" });
                } else {
                    $(".supplyUnit").text("");
                }
                if (supplyPeriod === "Select period") {
                    $(".supplyPeriod")
                        .text("Please select period")
                        .css({ color: "red" });
                } else {
                    $(".supplyPeriod").text("");
                }
                // if (deliveryTime === "") {
                //     $(".deliveryTime")
                //         .text("This field is required")
                //         .css({ color: "red" });
                // } else {
                //     $(".deliveryTime").text("");
                // }
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
            if (responseText === "success") {
                alert("The Product was added successfully!");
                window.location = "/u/add-new-product";
            }
        });

        this.on("sending", function (file, responseText) {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                positionClass: "toast-top-full-width",
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "8000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };

            Command: toastr["warning"](
                "Please wait....."
            );
        });



        this.on("error", function(file, data, xhr, responseText) {
            if (file.status == "error") {
                this.removeFile(file);
            }
        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("mainCategory", jQuery("#mc_id").val());
            formData.append("Category", jQuery("#c_id").val());
            formData.append("subCategory", jQuery("#subCategory").val());
            formData.append("Product_Name", jQuery("#Product_Name").val());
            //speccifications

            var specParentIds = [],
                spec_option = [];

            $("input[class='spec_option']").each(function() {
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
            $("input[class='add_spec_parent']").each(function() {
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
            $("input[class='add_spec']").each(function() {
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


/*=========product-edit-questionsAnd Answers===========*/
function deleteQuestionAndAswer(question_id) {
 jQuery(function() {
        var res = confirm(" Are you sure you want to delete ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/deleteQuestionAndAswer",
                data: { question_id: question_id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (data) {
                    $("#que" + question_id).fadeOut();
                    $("#example1").load(window.location.href + " #example1");
                }
            });
        }
    });
}
/*===================Answer show and update ===========================*/
function showAnswer(id) {
    $.ajax({
        type: "GET",
        url: "/u/get-answer",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
          beforeSend:function(){
            $(".answerUpdate").prop('disabled', true).val("Please wait..."); 
        },
        complete:function(){
            $(".answerUpdate").prop('disabled', false); 
        },
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                var id = data[i].id;
                var answer = data[i].answer;
            }
            $(".answerUpdate").val(answer);
            $("#ansId").text(id).hide();
        }
    });
}

function updateAnswer() {
    var valid = false;
    if ($(".answerUpdate").val() == "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else {
        var answer = $(".answerUpdate").val();
        var id = $("#ansId").text();
        $(".answerUpdate").val(answer);
        $("#ansId").text(id);
        $('#modal-answer').modal('toggle');
        valid = true;
        $.ajax({
            type: "POST",
            url: "/u/update-answer",
            data: { answer: answer, id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (data) {
                window.location.reload();
            }
        });



    }

}

/*===================Questionn show and update ===========================*/
function showQuestion(id) {
    $.ajax({
        type: "GET",
        url: "/u/get-question",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
         beforeSend:function(){
            $(".questionUpdate").prop('disabled', true).val("Please wait..."); 
        },
        complete:function(){
            $(".questionUpdate").prop('disabled', false); 
        },
        success: function (data) {

            for (var i = 0; i < data.length; i++) {
                $id = data[i].id;
                $question = data[i].question;
            }
            $(".questionUpdate").val($question);
            $("#queId").text($id).hide();
        }
    });
}

function updateQuestion() {
    var valid = false;
    if ($(".questionUpdate").val() == "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else {
        var question = $(".questionUpdate").val();
        var id = $("#queId").text();
        $('#modal-question').modal('toggle');
        valid = true;
        $.ajax({
            type: "POST",
            url: "/u/update-question",
            data: { question: question, id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (data) {
                window.location.reload();
            }
        });



    }

}


function sendQuestions(id) {
    var questions = [];
    var answers = [];
    var valid = false;
    if ($("#question1").val() != "" && $("#answer1").val() == "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question1").val() == "" && $("#answer1").val() != "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question1").val() != "" && $("#answer1").val() != "") {
        questions.push($("#question1").val());
        answers.push($("#answer1").val())
        valid = true;
    }
    if ($("#question2").val() != "" && $("#answer2").val() == "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question2").val() == "" && $("#answer2").val() != "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question2").val() != "" && $("#answer2").val() != "") {
        questions.push($("#question2").val());
        answers.push($("#answer2").val())
        valid = true;
    }
    if ($("#question3").val() != "" && $("#answer3").val() == "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question3").val() == "" && $("#answer3").val() != "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question3").val() != "" && $("#answer3").val() != "") {
        questions.push($("#question3").val());
        answers.push($("#answer3").val())
        valid = true;
    }
    if ($("#question4").val() != "" && $("#answer4").val() == "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question4").val() == "" && $("#answer4").val() != "") {
        alert("Please provide both an answer and a question")
        valid = false;
    } else if ($("#question4").val() != "" && $("#answer4").val() != "") {
        questions.push($("#question4").val());
        answers.push($("#answer4").val())
        valid = true;
    }
    if (valid == true) {

        var answers = answers.toString();
        var questions = questions.toString();
        $.ajax({
            type: "POST",
            url: "/u/questions-answers",
            data: { pd_id: id, answers: answers, questions: questions },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
               beforeSend:function(){
                    toastr.options = {
                    closeButton: true,
                    debug: false,
                    newestOnTop: false,
                    progressBar: false,
                    positionClass: "toast-top-center",
                    preventDuplicates: false,
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

                    Command: toastr["warning"](
                    "Please wait...!"
                    );
                },

                complete: function () {
                   
                },
            success: function (data) {
                window.location.reload();
                alert(data);
            }
        });

    }



}
