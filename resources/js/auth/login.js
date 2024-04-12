import $ from "jquery";
$(document).ready(function () {
    $("#login-form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Get the email and password from the input fields
        // Get the CSRF token value from the meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        const email = $("#email").val();
        const password = $("#password").val();

        // Make AJAX request to submit login credentials
        $.ajax({
            url: "/login",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken, // Include CSRF token in headers
            },
            data: { email: email, password: password },
            success: function (response) {
                // Handle successful login response
                const token = response.token;
                console.log(token); // Log the token value

                // Store the token in localStorage
                localStorage.setItem("token", token);

                // Redirect to the homepage or perform any other actions as needed
                window.location.href = "/"; // Redirect to the homepage
            },
            error: function (xhr, status, error) {
                // Handle login error
                console.error("Login error:", error);
            },
        });
    });
});
