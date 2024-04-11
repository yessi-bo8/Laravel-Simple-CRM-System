import $ from "jquery";

export function showMessage(type, message, projectId) {
    // Create a div element for the modal
    var modalContainer = $("<div></div>").addClass("modal-container");

    // Create a div element for the modal content
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

    // Append the modal content to the modal container
    modalContainer.append(modalContent);

    // Append the modal container to the body
    $("body").append(modalContainer);

    // Show the modal
    modalContainer.show();

    // If the type is "success", add the "Go to Project" button
    if (type === "success" && projectId) {
        // Create a button element for "Go to Project"
        var goToProjectButton = $("<button>Go to Project</button>")
            .attr("id", "go-to-project")
            .addClass("btn")
            .addClass("btn-primary")
            .click(function () {
                // Redirect to the corresponding project page
                window.location.href = "/projects/" + projectId;
            });

        // Append the "Go to Project" button to the modal content
        modalContent.append(goToProjectButton);
    }
}
