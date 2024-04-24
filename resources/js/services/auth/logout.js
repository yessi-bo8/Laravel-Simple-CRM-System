import $ from "jquery";
import { csrfToken } from "../../config/config.js";
import { showMessage } from "../../components/message.js";
import { handleError } from "../../utils/errors.js";
import { getErrorMessage } from "../../components/message.js";

$(document).ready(function () {
    $("#logout-button").click(function (event) {
        event.preventDefault();

        // Remove the token from local storage
        localStorage.removeItem("token");

        $.ajax({
            url: "/logout",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                showMessage("success", "Successfully logged out.");
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
