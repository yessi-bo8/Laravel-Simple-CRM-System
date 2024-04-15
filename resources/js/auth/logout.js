import $ from "jquery";
import { csrfToken } from "../config.js";
import { showMessage } from "../message.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

$(document).ready(function () {
    $("#logout-button").click(function (event) {
        event.preventDefault(); // Prevent default form submission behavior

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
                window.location.href = "/";
                showMessage("success", "Successfully logged out.");
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                showMessage("error", getErrorMessage(response));
                handleError;
            },
        });
    });
});
