import $ from "jquery";
import { csrfToken } from "../../config/config.js";
import { showMessage } from "../../components/message.js";
import { handleError } from "../../utils/errors.js";
import { getErrorMessage } from "../../components/message.js";

$(document).ready(function () {
    $("#login-form").submit(function (event) {
        event.preventDefault();

        const email = $("#email").val();
        const password = $("#password").val();

        $.ajax({
            url: "/login",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: { email: email, password: password },
            success: function (response) {
                // Store the token in localStorage
                const token = response.data.token;
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
