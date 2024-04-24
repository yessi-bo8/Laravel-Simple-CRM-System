import $ from "jquery";
import { token } from "../../config/config.js";
import { showMessage } from "../../components/message.js";
import { handleError } from "../../utils/errors.js";
import { getErrorMessage } from "../../components/message.js";

$(document).ready(function () {
    $(".delete-client").on("click", function () {
        const clientId = $(this).data("client-id");
        console.log("Client ID:", clientId);

        // Call the deleteProject function with the client ID
        deleteProject(clientId);
    });
});

export function deleteProject(clientId) {
    $.ajax({
        url: `/api/v1/clients/${clientId}`,
        headers: {
            Authorization: "Bearer " + token,
        },
        method: "DELETE",
        success: function () {
            showMessage("success", "Client deleted successfully.");
            setTimeout(function () {
                window.location.href = "/clients";
            }, 1000);
        },
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}
