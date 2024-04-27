import $ from "jquery";
import { csrfToken } from "../../config/config.js";
import { showMessage } from "../../components/message.js";
import { handleError } from "../../utils/errors.js";
import { getErrorMessage } from "../../components/message.js";

$(document).ready(function () {
    console.log("Document ready");
    $("#register-form").submit(function (event) {
        event.preventDefault();

        const email = $("#email").val();
        const password = $("#password").val();
        const password_confirmation = $("#password_confirmation").val();
        const name = $("#name").val();

        $.ajax({
            url: "/register",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
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
                    window.history.back();
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
