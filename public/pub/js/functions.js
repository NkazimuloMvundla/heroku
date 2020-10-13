jQuery(function() {
    $("#search").keyup(function() {
        var query = $(this).val();
        if (query !== "") {
            $.ajax({
                type: "POST",
                url: "/autocomplete/fetch",
                data: { query: query },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    if(data === 'No match found'){
                    $(".countryList").hide();
                    }else{
                     $(".countryList").fadeIn();
                    $(".countryList").html(data);
                    }
                }
            });
        } else if ($("#search").val() === "") {
            $(".countryList").hide();
        }
    });

    $(document).on("click", "li#pd_search", function() {
        $("#search").val($(this).text());
        $(".countryList").fadeOut();
    });
});

function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
//subscriber
jQuery(function(e) {
    $("#subscribe-btn").on("click", function(e) {
        e.preventDefault();
        var email = $("#newsletter").val();
        var valid = false;
        if (email === "") {
            alert("Please enter an email address");
            valid = false;
        } else if (emailIsValid(email) === false) {
            alert("Please enter valid email");
            valid = false;
        } else {
            $.ajax({
                type: "POST",
                url: "/subscriber",
                data: { email: email },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    alert(data);
                }
            });
        }
    });
});
//auto complete mobile
jQuery(function() {
    $("#search-mobile").keyup(function() {
        var query = $(this).val();
        if (query !== "") {
            $.ajax({
                type: "POST",
                url: "/autocomplete/fetch",
                data: { query: query },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                  if(data === 'No match found'){
                    $(".countryList").hide();
                    }else{
                     $(".countryList").fadeIn();
                    $(".countryList").html(data);
                    }
                }
            });
        } else if ($("#search-mobile").val() === "") {
            $("#search_mobile").hide();
        }
    });

    $(document).on("click", "li#pd_search", function() {
        $("#search_mobile").val($(this).text());
        $("#search_mobile").fadeOut();
    });
});

//search
function validSearch() {
    var searchtext = document.getElementById("search");
    if (searchtext.value === "") {
        //alert("Please input a keywords");
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

        Command: toastr["error"]("Please enter a keyword!");

        searchtext.focus();
        return false;
    } else {
        return true;
    }
}

function validSearchM() {
    var searchtext = document.getElementById("search-mobile");
    if (searchtext.value === "") {
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

        Command: toastr["error"]("Please enter a keyword!");
        searchtext.focus();
        return false;
    } else {
        return true;
    }
}

//add to fourites
function myFavorite(id) {
    if ($("#u_id").val() !== "") {
        $.ajax({
            type: "POST",
            url: "/u/favorites",
            data: { id: id, u_id: $("#u_id").val() },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                if (data == 1) {
                    $("#add-to-favs" + id).css({ color: "red" });
                } else {
                    $("#add-to-favs" + id).css({ color: "black" });
                }
            }
        });
    } else {
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
            "You must be logged in before adding to your favourites!"
        );
    }
}
jQuery(function() {
    $(".add-to-favs").on("click", function() {
        var id = $(this).data("id");
        myFavorite(id);
    });
});

/*end of add to favourites function */

//all-buying-request
function showRequest(id) {
    $.ajax({
        type: "POST",
        url: "/singleBuyingRequest",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                $id = data[i].id;
                $br_pc_name = data[i].br_pc_name;
                $br_pd_spec = data[i].br_pd_spec;
            }
            $("#modal-title").text($br_pc_name);
            $("#br_pd_spec").text($br_pd_spec);
        }
    });
}

function showSellingRequest(id) {
    $.ajax({
        type: "POST",
        url: "/singleSellingRequest",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                var id = data[i].id;
                var sr_pc_name = data[i].sr_pc_name;
                var sr_pd_spec = data[i].sr_pd_spec;
                var message = data[i].message;
            }
            $("#modal-title").text(sr_pc_name);
            $("#sr_pd_spec").text(sr_pd_spec);
            $("#sr_message").text(message);
        },
        error: function(data) {
            console.log("Error", data);
        }
    });
}

/*end of all buying req function */

//==================================PODUCT DETAIL==================================//

//==============================Buying Requests==============================//

jQuery(function() {
    var characters = 50;
    $("#countDown").append(characters);
    $("#br_pd_spec").on("keyup", function() {
        if ($(this).val().length > characters) {
            $(this).val(
                $(this)
                    .val()
                    .substr(0, characters)
            );
        }
        var remaining = characters - $(this).val().length;
        $("#countDown").html(remaining);

        if (remaining <= 10) {
            $("#remainingNumber").css("color", "red");
        } else {
            $("#remainingNumber").css("color", "black");
        }
    });
});

function showCat(id) {
    $.ajax({
        type: "POST",
        url: "/subcats",
        data: { _token: $('[name="token"]').val(), id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            var select = "";
            select +=
                "<option  selected disabled>" +
                "Select Category" +
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
                '<select class="form-control" name="subCategory" id="subCategory" >';
            select +=
                '<option value="" selected disabled>' +
                "Select SubCategory" +
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
            select += "</select";
            $("#last").html(select);
        }
    });
}

/*===================Product Detail========================*/

function sendReview(id) {
    if ($("#u_id").val() !== "") {
        var product_id = id;
        var name = $("#apr_name").val();
        var comment = $("#comment").val();
        var rating = $("input[name='rating']:checked").val();
        $(".alert-danger").hide();
        $(".alert-danger").html("");
        if (name.trim() === "") {
            alert("Your Name is Required !!!");
            $("#apr_name").focus();
            return false;
        }

        if (comment.trim() === "") {
            alert("Your comment is required !!!");
            $("#comment").focus();
            return false;
        }
        if (!rating) {
            alert("Please give your rating.....");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "/reviews",
                data: {
                    name: name,
                    rating: rating,
                    comment: comment,
                    product_id: product_id
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
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {

                    if(data === "error"){
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

                        Command: toastr["error"](
                        "You already posted your review..!"
                        );
                    }else{
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

                        Command: toastr["success"](
                        " You review was posted successfully..!"
                        );
                    }

                    $("#review-form").load(
                        window.location.href + " #review-form"
                    );
                },
                error: function(request, status, error) {
                    json = JSON.parse(request.responseText);
                    $.each(json.errors, function(key, value) {
                        $(".alert-danger").show();
                        $(".alert-danger").append("<p>" + value + "</p>");
                    });
                    $("#result").html("");
                }
            });
        }
    } else {
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

        Command: toastr["error"](
            "You must be logged in before you can leave any review!"
        );
    }
}

jQuery(function() {
    $("#registration_form").validate({
        rules: {
            mainCategory: "required",
            Category: "required",
            subCategory: "required",
            productName: "required",
            detailedSpecification: "required",
            orderQuantityUnit: "required",
            orderQuantity: {
                required: true,
                number: true
            }
        },
        messages: {
            mainCategory: "This field is required",
            Category: "This field is required",
            subCategory: "This field is required",
            productName: "This field is required",
            detailedSpecification: "This field is required",
            orderQuantityUnit: "This field is required",
            orderQuantity: {
                required: "This field is required",
                number: "This field must be numeric"
            }
        }
    });
});

/*===================buy-req===========================*/
jQuery(function() {
    $("#postBuyRequestForm").validate({
        rules: {
            mainCategory: "required",
            c_id: "required",
            subCategory: "required",
            productName: "required",
            detailedSpecification: "required",
            orderQuantityUnit: "required",
            orderQuantity: {
                required: true,
                number: true
            }
        },
        messages: {
            mainCategory: "This field is required",
            c_id: "This field is required",
            subCategory: "This field is required",
            productName: "This field is required",
            detailedSpecification: "This field is required",
            orderQuantityUnit: "This field is required",
            orderQuantity: {
                required: "This field is required",
                number: "This field must be numeric"
            }
        }
    });
});

/*================send-buy-message================*/
jQuery(function() {
    $("#send_selling_message").validate({
        rules: {
            subject: "required",
            message: "required",
            comment: "required",
            price: {
                required: true,
                number: true
            },
            quantityUnit: {
                required: true
            },
            quantity: {
                required: true,
                number: true
            }
        },
        messages: {
            subject: "This filed is required",
            message: "This filed is required",
            price: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            quantityUnit: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            quantity: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            comment: "This filed is required"
        }
    });
});

/*==================selling-req===========================*/
jQuery(function() {
    $("#postBuyRequestForm").validate({
        rules: {
            mainCategory: "required",
            c_id: "required",
            subCategory: "required",
            productName: "required",
            message: "required",
            detailedSpecification: "required",
            orderQuantityUnit: "required",
            orderQuantity: {
                required: true,
                number: true
            }
        },
        messages: {
            mainCategory: "This field is required",
            c_id: "This field is required",
            subCategory: "This field is required",
            productName: "This field is required",
            message: "This field is required",
            detailedSpecification: "This field is required",
            orderQuantityUnit: "This field is required",
            orderQuantity: {
                required: "This field is required",
                number: "This field must be numeric"
            }
        }
    });
});

/*==================send-selling-message========================*/
jQuery(function() {
    $("#send_selling_message").validate({
        rules: {
            subject: "required",
            message: "required",
            comment: "required",
            price: {
                required: true,
                number: true
            },
            quantityUnit: {
                required: true
            },
            quantity: {
                required: true,
                number: true
            }
        },
        messages: {
            subject: "This filed is required",
            message: "This filed is required",
            price: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            quantityUnit: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            quantity: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            comment: "This filed is required"
        }
    });
});

/*===========================contact-supplier==================================*/
jQuery(function() {
    $("#contactSupplierStore").validate({
        rules: {
            subject: "required",
            message: "required",
            price: {
                required: true,
                number: true
            },
            quantityUnit: {
                required: true
            },
            quantity: {
                required: true,
                number: true
            }
        },
        messages: {
            subject: "This filed is required",
            message: "This filed is required",
            price: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            quantityUnit: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            },
            quantity: {
                required: "This filed is required",
                number: "This filed is must be a numeric value"
            }
        }
    });
});
