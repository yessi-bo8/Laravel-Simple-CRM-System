import $ from "jquery";
$(document).ready(function () {
    $("#logout-button").click(function (event) {
        event.preventDefault(); // Prevent default form submission behavior

        // Log "hoi" to console
        console.log("hoi");

        // Get the CSRF token value from the meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        // Remove the token from local storage
        localStorage.removeItem("token");

        // Make AJAX request to logout
        $.ajax({
            url: "/logout",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken, // Include CSRF token in headers
            },
            success: function (response) {
                // Redirect to the homepage or perform any other actions as needed
                window.location.href = "/"; // Redirect to the homepage
            },
            error: function (xhr, status, error) {
                // Handle logout error
                console.error("Logout error:", error);
            },
        });
    });
});
