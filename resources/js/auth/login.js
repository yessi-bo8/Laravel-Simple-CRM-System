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
                // Store the token in localStorage
                localStorage.setItem("token", token);
                showMessage("success", response.message);
                setTimeout(function () {
                    window.location.href = "/";
                }, 1000);
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                showMessage("error", getErrorMessage(response));
                handleError;
            },
        });
    });
});
