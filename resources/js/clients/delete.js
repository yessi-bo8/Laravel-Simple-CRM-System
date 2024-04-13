import $ from "jquery";
import { token } from "../config.js";
import { showMessage } from "../message.js";
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
        url: `/clients/${clientId}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Include CSRF token
            Authorization: "Bearer " + token,
        },
        method: "DELETE",
        success: function () {
            window.location.href = "/clients";
            showMessage("success", "Client deleted successfully.");
            console.log("success");
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

// Function to handle errors
function handleError(xhr, status, error) {
    console.error(error);
}
