import $ from "jquery";

export function showMessage(type, message, projectId) {
    var modalContainer = $("<div></div>").addClass("modal-container");
    var modalContent = $("<div></div>").addClass("modal-content");

    var closeButton = $("<span>&times;</span>").addClass("close-button");
    closeButton.click(function () {
        modalContainer.hide();
    });

    var messageDiv = $("<div></div>").attr("id", "message").text(message);
    modalContent.append(closeButton, messageDiv);
    modalContainer.append(modalContent);
    $("body").append(modalContainer);

    modalContainer.show();

    if (type === "success") {
        modalContent.attr("id", "success-container");
    }

    if (type === "error") {
        modalContent.attr("id", "error-container");
    }
}

// Function to get error message from response
export function getErrorMessage(response) {
    if (response.errors) {
        // If there are validation errors, construct error message
        let errorMessage = "Validation error(s): ";
        Object.keys(response.errors).forEach((field) => {
            errorMessage += `${response.errors[field]}\n`;
        });
        return errorMessage;
    } else if (response.error) {
        // If there's a general error message, return it
        return response.error;
    } else {
        // If no specific error message is found, return a generic message
        return "Error occured.";
    }
}
