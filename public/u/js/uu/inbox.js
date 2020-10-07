function updateStatus(id) {
    $.ajax({
        type: "POST",
        url: "/u/updateStatus",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {}
    });
}
function checkedAl() {
    var check = $('input[name="emails[]"]:checked').length;
    if (check > 0) {
        jQuery(function() {
            var res = confirm(" Are you sure you want to delete ? ");
            if (res) {
                var notChecked = [],
                    checked = [];
                $("input:checkbox").map(function() {
                    this.checked
                        ? checked.push(this.id)
                        : notChecked.push(this.id);
                });

                $.ajax({
                    type: "POST",
                    url: "/u/destroyEmails",
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
                return res;
            }
        });
    } else {
        alert("Please check atleast one! ");
    }
}
function showBuyerDetails(id) {
    $.ajax({
        type: "GET",
        url: "/u/showBuyerDetails",
        data: { id: id },
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                var id = data[i].id;
                var company_name = data[i].company_name;
                var lastname = data[i].lastname;
                var name = data[i].name;
                var about_us = data[i].about_us;
                var zip_code = data[i].zip_code;
                var country = data[i].country;
            }
            $("#company_name").text(company_name);
            $("#lastname").text(lastname);
            $("#name").text(name);

            $("#zip_code").text(zip_code);
            $("#country").text(country);
            if (about_us == "" || about_us == null) {
                $("#about_us").text("Not provided yet!");
            } else {
                $("#about_us").text(about_us);
            }
        }
    });
}
//sent

// function checkedAll() {
//     var check = $('input[name="emails[]"]:checked').length;
//     if (check > 0) {
//       jQuery(function() {
//             var res = confirm(" Are you sure you want to delete ? ");
//             if (res) {
//                 var notChecked = [],
//                     checked = [];
//                 $("input:checkbox").map(function() {
//                     this.checked
//                         ? checked.push(this.id)
//                         : notChecked.push(this.id);
//                 });
//                 // console.log("Checked " + checked);
//                 // console.log("Not checked " + notChecked);

//                 $.ajax({
//                     type: "POST",
//                     url: "/admin/destroyEmails",
//                     data: { checked: checked },
//                     headers: {
//                         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
//                             "content"
//                         )
//                     },
//                     success: function(data) {
//                         $(".box-title").text("Deleting...");
//                         window.location = "{{ route('SentEmail') }}";
//                     },
//                     error: function(data) {
//                         console.log("Error:", data);
//                     }
//                 });
//             } else {
//                 return res;
//             }
//         });
//     } else {
//         alert("Please check atleast one ");
//     }
// }
// //all

// function checkedAll() {
//     var check = $('input[name="emails[]"]:checked').length;
//     if (check > 0) {
//       jQuery(function() {
//             var res = confirm(" Are you sure you want to delete ? ");
//             if (res) {
//                 var notChecked = [],
//                     checked = [];
//                 $("input:checkbox").map(function() {
//                     this.checked
//                         ? checked.push(this.id)
//                         : notChecked.push(this.id);
//                 });
//                 // console.log("Checked " + checked);
//                 // console.log("Not checked " + notChecked);

//                 $.ajax({
//                     type: "POST",
//                     url: "/admin/destroyEmails",
//                     data: { checked: checked },
//                     headers: {
//                         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
//                             "content"
//                         )
//                     },
//                     success: function(data) {
//                         $(".box-title").text("Deleting...");
//                         window.location = "{{ route('allEmails') }}";
//                     }
//                 });
//             } else {
//                 return res;
//             }
//         });
//     } else {
//         alert("Please check atleast one ");
//     }
// }

// //read

// function sendMessage(id) {
//   jQuery(function() {
//         $("#send-message").click(function(e) {
//             e.preventDefault();
//             var msg_from_id = $("#msg_from_id").val();
//             var msg_to_id = $("#msg_to_id").val();
//             var subject = $("#subject").val();
//             var message = $("#compose-textarea").val();

//             if (subject == "") {
//                 $("#subjectErr").text("Please enter a Subject");
//             } else if (message == "") {
//                 $("#messageErr").text("Please enter a message");
//             } else if (subject != "" && message != "") {
//                 // $("#messageErr").text("");
//                 $.ajax({
//                     type: "POST",
//                     url: "/admin/reply",
//                     data: {
//                         msg_from_id: msg_from_id,
//                         msg_to_id: msg_to_id,
//                         subject: subject,
//                         message: message,
//                         reply_attachment: reply_attachment
//                     },
//                     headers: {
//                         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
//                             "content"
//                         )
//                     },
//                     success: function(data) {
//                         $(".modal-content").html(
//                             "<div class='alert alert-success' style='font-size:22px;'>Your message was sent successfully</div>"
//                         );
//                         window.location = "/admin/mailbox/inbox";
//                     },
//                     error: function(data) {
//                         json = $.parseJSON(request.responseText);
//                         $.each(json.errors, function(key, value) {
//                             $(".alert-danger").show();
//                             $(".alert-danger").append("<p>" + value + "</p>");
//                         });
//                         $("#result").html("dhfj");
//                     }
//                 });
//             } else {
//                 return false;
//             }
//         });
//     });
// }
