import $ from "jquery";
import { token } from "../config.js";
import { showMessage } from "../message.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

$(document).ready(function () {
    // Add event listener for delete client button
    $(".delete-client").on("click", function () {
        // Get the client ID from the data attribute
        const clientId = $(this).data("client-id");
        console.log("Client ID:", clientId);

        // Call the deleteProject function with the client ID
        deleteProject(clientId);
    });
});

// Function to delete project
export function deleteProject(clientId) {
    $.ajax({
        url: `/api/v1/clients/${clientId}`,
        headers: {
            Authorization: "Bearer " + token,
        },
        method: "DELETE",
        success: function () {
            window.location.href = "/clients";
            showMessage("success", "Client deleted successfully.");
        },
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}
