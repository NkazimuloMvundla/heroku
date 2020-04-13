// validate signup form on keyup and submit

$(document).ready(function() {
    $("#updateProfile").validate({
        rules: {
            about_us: "required",
            company_name: "required",
            company_address: "required",
            zip_code: {
                required: true,
                number: true
            },
            phone_number: {
                required: true,
                number: true
            }
        },
        messages: {
            about_us: "This field is required",
            company_name: "This field is required",
            company_address: "This field is required",
            zip_code: {
                number: "This must be a number"
            },
            phone_number: {
                number: "This must be a number"
            }
        }
    });
});

$(document).ready(function() {
    var chekha;
    $(".market").on("click", function() {
        var notChecked = [],
            checked = [];
        $("input:checkbox").map(function() {
            this.checked
                ? checked.push(this.value)
                : notChecked.push(this.value);
        });

        chekha = checked.toString();
    });
    document.getElementById("save-export").addEventListener("click", e => {
        e.preventDefault();

        var selectElement = document.querySelector("#export_percentage");
        var element = selectElement.options[selectElement.selectedIndex].value;
        var export_years = document.querySelector("#year_started_exporting");
        var export_started =
            export_years.options[export_years.selectedIndex].value;
        if (element == "select") {
            alert("Please select an export percentage");
        } else if (!jQuery(".market").is(":checked")) {
            alert("Please select atleast one market");
        } else if (export_started == "select") {
            alert("Please select the year started exporting");
        }

        //if checkha isset
        if (chekha != "undefined") {
            $.ajax({
                url: "/u/profile",
                method: "POST",
                data: {
                    export_percentage: element,
                    export_year: export_started,
                    chekha: chekha
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    alert("Success");
                }
            });
        } else {
            $.ajax({
                url: "/u/profile",
                method: "POST",
                data: {
                    export_percentage: element,
                    export_year: export_started
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    alert("Success");
                }
            });
        }
    });
});

//delete certificate

function deleteCompanyCertificate(id) {
    $(document).ready(function() {
        var res = confirm(" Are you sure you want to delete ? ");
        if (res) {
            $.ajax({
                type: "POST",
                url: "/u/profile/delete-certificate",
                data: { id: id },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    window.location.reload();
                },
                error: function(data) {
                    console.log("Erro", data);
                }
            });
        }
    });
}

//certificates upload
Dropzone.options.myDropzoneCertificate = {
    // Dropzone.autoDiscover = false;
    url: "/u/profile/certificate",
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 3,
    maxFiles: 3,
    maxFilesize: 3,
    acceptedFiles: "image/*, docx",
    addRemoveLinks: true,

    success: function(responseText, data) {
        alert("Certificate added successfully");
    },

    error: function(file, response, error) {
        if (error) {
            json = $.parseJSON(error.responseText);
            $.each(json.errors, function(key, value) {
                $(".alert-danger").show();
                $(".alert-danger").append("<p>" + value + "</p>");
            });
            $("#result").html("");
        }
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
        dzClosure = this;
        // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document
            .getElementById("submitFormBtn")
            .addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });
        this.on("drop", function(file) {
            $("#submitFormBtn").removeAttr("disabled");
        });

        this.on("addedfile", function(file) {
            //   alert("File Added");
            $("#submitFormBtn").removeAttr("disabled");
            $("#dz-error-message").text("");
        });

        this.on("removedfile", function(file) {
            $("#submitFormBtn").attr("disabled", "disabled");
        });

        this.on("success", function(file, responseText) {
            if (responseText == "success") {
                alert("File was added");
                window.location = "{{ route('Profile') }}";
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
            formData.append("send", "data");
        });
    }
};
