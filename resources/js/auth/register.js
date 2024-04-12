import $ from "jquery";
$(document).ready(function () {
    console.log("Document ready");
    $("#register-form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        console.log("hoi");
        // Get the email and password from the input fields
        // Get the CSRF token value from the meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        const email = $("#email").val();
        const password = $("#password").val();
        const password_confirmation = $("#password_confirmation").val();
        const name = $("#name").val();

        // Make AJAX request to submit login credentials
        $.ajax({
            url: "/register",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken, // Include CSRF token in headers
            },
            data: {
                email: email,
                password: password,
                password_confirmation: password_confirmation,
                name: name,
            },
            success: function (response) {
                // Handle successful register response
                console.log("sucessfull registered");

                // Redirect to the homepage or perform any other actions as needed
                window.location.href = "/login"; // Redirect to the homepage
            },
            error: function (xhr, status, error) {
                // Handle login error
                console.error("Login error:", error);
            },
        });
    });
});
