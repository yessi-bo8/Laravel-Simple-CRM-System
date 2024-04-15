import $ from "jquery";
import { token } from "../config.js";
import { showMessage } from "../message.js";
import { getErrorMessage } from "../message.js";
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
    let clientOptions = "";
    let userOptions = "";

    // Load clients, users, and tasks concurrently
    Promise.all([
        fetch("/api/v1/clients", {
            headers: { Authorization: "Bearer " + token },
        }),
        fetch("/api/v1/users", {
            headers: { Authorization: "Bearer " + token },
        }),
    ])
        .then((responses) =>
            Promise.all(responses.map((response) => response.json()))
        )
        .then(([clientsResponse, usersResponse]) => {
            // Process clients data
            const clients = clientsResponse.data;
            clientOptions = clients
                .map(
                    (client) =>
                        `<option value="${client.attributes.name}">${client.attributes.name}</option>`
                )
                .join("");

            // Process users data
            const users = usersResponse.data;
            userOptions = users
                .map(
                    (user) =>
                        `<option value="${user.attributes.name}">${user.attributes.name}</option>`
                )
                .join("");
            console.log("User Options:", userOptions); // Log the user options

            // Show form after all data is loaded
            showForm();
        })
        .catch((error) => {
            console.error("Error loading data:", error);
        });

    // Function to show the form after clients, users, and tasks are loaded
    function showForm() {
        $(".project-container").html(`
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
        
                    <label for="user_name">Assignee:</label>
                    <select name="user_name">
                        <option value="">Select User</option>
                        ${userOptions}
                    </select>
                    <div id="user_name-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for user_id -->
                    <br />

                    <label for="client_name">Client:</label>
                    <select name="client_name">
                        <option value="">Select Client</option>
                        ${clientOptions} 
                    </select>
                    <div id="client_name-error" class="alert alert-danger form_danger" style="display: none;"></div>
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
    }

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
                // Parse the error response
                const response = xhr.responseJSON;

                // Show the error message using showMessage function
                // Show the error message using showMessage function
                showMessage("error", getErrorMessage(response));
            },
        });
    });
}
