import $ from "jquery";
import { csrfToken } from "../config.js";
import { showMessage } from "../message.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

$(document).ready(function () {
    console.log("Document ready");
    $("#register-form").submit(function (event) {
        event.preventDefault();
        console.log("hoi");

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
                console.log("sucessfull registered");
                showMessage("success", response.message);
                setTimeout(function () {
                    window.location.href = "/login";
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
