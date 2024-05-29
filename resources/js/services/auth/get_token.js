import $ from "jquery";
import { showMessage } from "../../components/message.js";

$(document).ready(function () {
    $("#getTokenBtn").click(function () {
        $.ajax({
            url: "/getToken",
            method: "GET",
            success: function (response) {
                console.log(response);
                console.log(response.token);
                const token = response.data.token;

                // Store the token in local storage
                localStorage.setItem("token", token);

                showMessage("success", response.message);
                setTimeout(function () {
                    window.location.href = "/";
                }, 1000);
            },
            error: function (xhr, status, error) {
                showMessage("error", "Failed to get token");
            },
        });
    });
});
