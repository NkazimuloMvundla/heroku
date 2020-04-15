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
                },
                error: function(data) {
                    console.log("err", data);
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
//subscriber
$(document).ready(function(e) {
    $("#subscribe-btn").on("click", function(e) {
        e.preventDefault();
        var mailformat = /^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/;
        var regex = /^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/;

        if ($("#newsletter").val() == "") {
            alert("Please enter an email address");
        } else if (regex.test($("#newsletter").val()) === false) {
            alert("Please enter a valid email address");
        } else {
            $.ajax({
                type: "POST",
                url: "/subscriber",
                data: { email: $("#newsletter").val() },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    alert(data);
                },
                error: function(data) {
                    console.log("Error", data);
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
                },
                error: function(data) {
                    console.log("err", data);
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
            },
            error: function(data) {
                console.log("Error", data);
            }
        });
    } else {
        window.location = "/login";
    }
}

document.getElementById("add-to-span").addEventListener("click", myFavorite);

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
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
}
function sendMessage(id) {
    $(document).ready(function() {
        $("#send-message").click(function(e) {
            e.preventDefault();
            $(".alert-danger").hide();
            $(".alert-danger").html("");
            var msg_from_id = $("#msg_from_id").val();
            var msg_to_id = id;
            var subject = $("#subject").val();
            var price = $("#price").val();
            var quantityUnit = $("#quantityUnit").val();
            var quantity = $("#quantity").val();
            var comment = $("#comment").val();
            if (subject == "") {
                $("#subjectErr").text("Please enter a Subject");
            } else if (price == "") {
                $("#priceErr").text("Please enter price");
            } else if (quantityUnit == "Select") {
                $("#quantityUnitErr").text("Please select Quantity Unit");
            } else if (quantity == "") {
                $("#quantityErr").text("Please enter quantity");
            } else {
                $.ajax({
                    type: "POST",
                    url: "/messages",
                    data: {
                        msg_from_id: msg_from_id,
                        msg_to_id: msg_to_id,
                        subject: subject,
                        price: price,
                        quantityUnit: quantityUnit,
                        quantity: quantity,
                        comment: comment
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    success: function(data) {
                        $(".modal-content").html(
                            "<div class='alert alert-success' style='font-size:22px;'>Your message was sent successfully</div>"
                        );
                        window.location = "/all-buying-requests";
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
        });
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
