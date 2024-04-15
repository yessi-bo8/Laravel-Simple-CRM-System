import $ from "jquery";

export function showMessage(type, message, projectId) {
    var modalContainer = $("<div></div>").addClass("modal-container");
    var modalContent = $("<div></div>").addClass("modal-content");

    // Create a span element for the close button
    var closeButton = $("<span>&times;</span>").addClass("close-button");
    closeButton.click(function () {
        // Hide the modal when the close button is clicked
        modalContainer.hide();
    });

    // Create a div element for the message
    var messageDiv = $("<div></div>").attr("id", "message").text(message);

    // Append the close button and message to the modal content
    modalContent.append(closeButton, messageDiv);
    modalContainer.append(modalContent);

    // Append the modal container to the body
    $("body").append(modalContainer);

    modalContainer.show();

    // If the type is "success", add the "Go to Project" button
    if (type === "success") {
        // window.location.href = "/projects/" + projectId;
        console.log("hhallooo!!!");
        modalContent.attr("id", "success-container");
    }

    if (type === "error") {
        modalContent.attr("id", "error-container");
    }
}

// Function to get error message from response
export function getErrorMessage(response) {
    if (response && response.errors) {
        // If there are validation errors, construct error message
        let errorMessage = "Validation error(s): ";
        Object.keys(response.errors).forEach((field) => {
            errorMessage += `${response.errors[field]}\n`;
        });
        return errorMessage;
    } else if (response && response.error) {
        // If there's a general error message, return it
        return response.error;
    } else {
        // If no specific error message is found, return a generic message
        return "Error occured.";
    }
}
