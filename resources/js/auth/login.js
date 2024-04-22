import $ from "jquery";
import { csrfToken } from "../config.js";
import { showMessage } from "../message.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

$(document).ready(function () {
    $("#login-form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        const email = $("#email").val();
        const password = $("#password").val();

        // Make AJAX request to submit login credentials
        $.ajax({
            url: "/login",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: { email: email, password: password },
            success: function (response) {
                // Handle successful login response
                const token = response.data.token;
                console.log(token); // Log the token value

                // Store the token in localStorage
                localStorage.setItem("token", token);

                // Redirect to the homepage or perform any other actions as needed
                window.location.href = "/"; // Redirect to the homepage
                showMessage("success", "Successfully logged in.");
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                showMessage("error", getErrorMessage(response));
                handleError;
            },
        });
    });
});
