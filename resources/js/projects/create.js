import $ from "jquery";
import { token } from "../config.js";
import { showMessage } from "../message.js";
import { fetchProjectDetails } from "./show.js";
// Function to handle project creation
// Function to display error message
function displayErrorMessage(fieldName, message) {
    const errorContainer = $(`#${fieldName}-error`);
    errorContainer.text(message);
    errorContainer.show(); // Show the error message
}

// Function to handle project creation
export function handleProjectCreation() {
    let clientOptions = ""; // Define clientOptions variable outside AJAX success callback

    // Load clients and populate the select menu
    $.ajax({
        url: "/api/v1/clients",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: function (clientsResponse) {
            const clients = clientsResponse.data;
            console.log(clients);

            // Generate client options
            clientOptions = clients
                .map(
                    (client) =>
                        `<option value="${client.attributes.name}">${client.attributes.name}</option>`
                )
                .join("");

            // Show form when the button is clicked

            $(".container").html(`
                <div class="form-container" >
                    <form id="create-project-form" method="POST">
                        <label>Title:</label>
                        <input type="text" name="title">
                        <div id="title-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for title -->
                        <br />
        
                        <label for="description">Description:</label>
                        <textarea name="description" rows="4" cols="50"></textarea>
                        <div id="description-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for description -->
                        <br />
        
                        <label>Date deadline:</label>
                        <input type="date" name="event_date">
                        <div id="event_date-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for event_date -->
                        <br />
        
                        <label for="client_name">Client:</label>
                        <select name="client_name">
                        <option value="">Select Client</option>
                        ${clientOptions}
                        </select>
                        <div id="client_name-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for client_name -->
                        <br />
        
                        <label for="status">Status:</label>
                        <select name="status">
                            <option value="">Select Status</option>
                            <option value="approved">approved</option>
                            <option value="pending">pending</option>
                            <option value="rejected">rejected</option>
                        </select>
                        <div id="status-error" class="alert alert-danger form_danger" style="display: none;"></div>
                        </br >
        
                        <button type="submit">Make new Project</button>
                    </form>
                    </div>
                `);
        },
        error: function (xhr, status, error) {
            console.error("Error loading clients:", error);
        },
    });

    // Handle form submission
    $(document).on("submit", "#create-project-form", function (event) {
        event.preventDefault();
        const formData = $(this).serializeArray(); // Serialize form data to an array
        const jsonData = {}; // Initialize an empty object for JSON data

        // Convert form data array to JSON object
        formData.forEach((field) => {
            jsonData[field.name] = field.value;
        });

        console.log("JSON Data:", jsonData); // Log JSON data before sending

        $.ajax({
            url: "/api/v1/projects",
            method: "POST",
            contentType: "application/json",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/vnd.api+json",
                Accept: "application/vnd.api+json",
            },
            data: JSON.stringify(jsonData), // Send JSON data instead of form data
            success: function (response) {
                const projectId = response.data.id;
                console.log("Project created successfully:", response);
                fetchProjectDetails(projectId);
                showMessage("success", "Project created successfully.");
            },
            error: function (xhr, status, error) {
                console.error("Error creating project:", error);

                // Parse the error response
                const response = xhr.responseJSON;

                // Display error messages for each field
                Object.keys(response.errors).forEach((fieldName) => {
                    const errorMessage = response.errors[fieldName].join(" "); // Join multiple error messages
                    displayErrorMessage(fieldName, errorMessage);
                });

                showMessage(
                    "error",
                    "Failed to create project. Please fix the errors and try again."
                );
            },
        });
    });
}
