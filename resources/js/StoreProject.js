import $ from "jquery";

$(document).on("submit", "#project-form", function (event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Serialize the form data
    var formData = $(this).serializeArray();
    var token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";
    // Convert formData to a plain object
    var data = {};
    $.each(formData, function (index, field) {
        data[field.name] = field.value;
    });

    // Send an AJAX POST request
    $.ajax({
        url: "/api/v1/projects",
        method: "POST",
        contentType: "application/json",
        dataType: "json",
        headers: {
            Authorization: `Bearer ${token}`, // Assuming you have a variable 'token' containing the JWT token
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
        },
        data: JSON.stringify(data), // Convert data to JSON string
        success: function (response) {
            // Handle successful response
            console.log("Project created successfully:", response);
            // Show success message
            showMessage("success", "Project created successfully.");
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.error("Error creating project:", error);
            // Show error message
            showMessage("error", "Failed to create project. Please try again.");
        },
    });
});

function showMessage(type, message, projectId) {
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
