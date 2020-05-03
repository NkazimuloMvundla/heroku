//product views
document
    .querySelector("[class=view_product]")
    .addEventListener("click", function(e) {
        alert("Clicked");
    });

//auto complete
$(document).ready(function() {
    $("#search").keyup(function() {
        var query = $(this).val();
        if (query != "") {
            $.ajax({
                type: "POST",
                url: "/autocomplete/fetch",
                data: { query: query },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $("#countryList").fadeIn();
                    $("#countryList").html(data);
                }
            });
        } else if ($("#search").val() == "") {
            $("#countryList").hide();
        }
    });

    $(document).on("click", "li#pd_search", function() {
        $("#search").val($(this).text());
        $("#countryList").fadeOut();
    });
});

function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
//subscriber
$(document).ready(function(e) {
    $("#subscribe-btn").on("click", function(e) {
        e.preventDefault();
        var email = $("#newsletter").val();
        var valid = false;
        if (email == "") {
            alert("Please enter an email address");
            valid = false;
        } else if (emailIsValid(email) == false) {
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
$(document).ready(function() {
    $("#search-mobile").keyup(function() {
        var query = $(this).val();
        if (query != "") {
            $.ajax({
                type: "POST",
                url: "/autocomplete/fetch",
                data: { query: query },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $("#search_mobile").fadeIn();
                    $("#search_mobile").html(data);
                }
            });
        } else if ($("#search-mobile").val() == "") {
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
    //alert(search_value);
    if (searchtext.value == "") {
        alert("Please input a keyword");
        searchtext.focus();
        return false;
    } else {
        return true;
    }
}

/*
//auto complete mobile
$(document).ready(function() {
 $("#search_btn").on("click", function(e) {
    e.preventDefault();
    var searchtext = document.getElementById("search");
    //alert(search_value);
    if (searchtext.value == "") {
        alert("Please input a keyword");
        searchtext.focus();
        return false;
    } else {
          console.log(searchtext.value)
             $.ajax({
                type: "POST",
                url: "/search",
                data: { pd_name: searchtext.value },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                console.log('Success', data)
                window.location = "/search";
                },
                error: function(data) {
                    console.log("err", data);
                }
            });

       }
   })
})
*/
function validSearchM() {
    var searchtext = document.getElementById("search-mobile");
    //alert(search_value);
    if (searchtext.value == "") {
        alert("Please input a keyword");
        searchtext.focus();
        return false;
    } else {
        return true;
    }
}

//add to fourites
function myFavorite(id) {
    if ($("#u_id").val() != "") {
        $.ajax({
            type: "POST",
            url: "/u/favorites",
            data: { id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                alert(data);
            }
        });
    } else {
        window.location = "/login";
    }
}

//document.getElementById("add-to-span").addEventListener("click", myFavorite);

/*end of add to favourites function */

//all-buying-request
function showRequest(id) {
    $.ajax({
        type: "GET",
        url: "/singleBuyingRequest",
        data: { id: id },
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
        type: "GET",
        url: "/singleSellingRequest",
        data: { id: id },
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

//=======================PODUCT DETAIL=======================//

//====================Buying Requests====================//

$(document).ready(function() {
    var characters = 50;
    $("#countDown").append(characters);
    $("#br_pd_spec").keyup(function() {
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
            var select =
                '<select class="form-control" name="Category" id="Category" onChange="showSubCat(this.value);">';
            select +=
                '<option value="" selected disabled>' +
                "Select Category" +
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
                //$("#coin").html("Judge"
            }
            select += "</select";
            $("#coin").html(select);
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

/*=============Product Detail================*/

function sendReview(id) {
    //alert("sidd");
    if ($("#u_id").val() != "") {
        var product_id = id;
        var name = $("#apr_name").val();
        var comment = $("#comment").val();
        var rating = $("input[name='rating']:checked").val();
        $(".alert-danger").hide();
        $(".alert-danger").html("");
        if (name.trim() == "") {
            alert("Your Name is Required !!!");
            $("#apr_name").focus();
            return false;
        }

        if (comment.trim() == "") {
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
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    alert("Your review has been posted successfully");
                    window.location =
                        "/product-details/{{ $product->first()->pd_id }} ";
                },
                error: function(request, status, error) {
                    json = $.parseJSON(request.responseText);
                    $.each(json.errors, function(key, value) {
                        $(".alert-danger").show();
                        $(".alert-danger").append("<p>" + value + "</p>");
                    });
                    $("#result").html("");
                }
            });
        }
    } else {
        window.location = "/login";
    }
}

$(document).ready(function() {
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
