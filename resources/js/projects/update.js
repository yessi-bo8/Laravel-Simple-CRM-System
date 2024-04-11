import $ from "jquery";
import { token } from "../config.js";
import { handleError } from "./errors.js";
import { showMessage } from "../message.js";
import { fetchProjectDetails } from "./show.js";

// Function to fetch clients and display update form
function fetchClientsAndDisplayUpdateForm(projectId) {
    $.ajax({
        url: "/api/v1/clients",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: function (clientsResponse) {
            const clients = clientsResponse.data;
            console.log(clients);

            // Generate client options
            const clientOptions = clients
                .map(
                    (client) =>
                        `<option value="${client.attributes.name}">${client.attributes.name}</option>`
                )
                .join("");

            // Show the update form
            displayUpdateForm(projectId, clientOptions);
        },
        error: handleError,
    });
}
async function displayUpdateForm(projectId, clientOptions) {
    // Now fetch project details
    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: async function (response) {
            const project = response.data.attributes;

            // Hide project details
            $(".container").empty();

            // Populate the form with project details
            const updateForm = `
                        <div class="form-container">
                            <div class="update-form">
                                <h1>Update Project</h1>
                                <form id="project-form">
                                    <input type="hidden" name="_token" value="${token}">
                                    <input type="hidden" name="project_id" value="${projectId}">
                                    <label>Title:</label>
                                    <input type="text" name="title" value="${project.title}">
                                    <br />
        
                                    <label for="description">Description:</label>
                                    <textarea name="description" rows="4" cols="50">${project.description}</textarea>
                                    <br />
        
                                    <label>Date deadline:</label>
                                    <input type="date" name="event_date" value="${project.event_date}">
                                    <br />
        
                                    <label for="client_name">Client:</label>
                                    <select name="client_name">
                                        ${clientOptions}
                                    </select>
                                    <br />
        
                                    <label for="status">Status:</label>
                                    <select name="status">
                                        <option value="approved">approved</option>
                                        <option value="pending">pending</option>
                                        <option value="rejected">rejected</option>
                                    </select>
                                    </br>
        
                                    <button type="submit">Update Project</button>
                                </form>
                            </div>
                        </div>
                    `;

            // Show the update form
            $(".container").append(updateForm);

            // Find the client name corresponding to the project's client ID
            const clientId = response.data.relationships.id_client;
            console.log(clientId);

            try {
                const name = await getClientNameFromId(clientId);
                console.log(name);

                // Set the default selected client in the select element
                $("select[name='client_name']").val(name);
            } catch (error) {
                console.error("Error getting client name:", error);
            }

            // Add event listener for form submission
            $("#project-form").submit(function (event) {
                event.preventDefault(); // Prevent the default form submission
                updateProject(projectId); // Call the updateProject function
            });
        },
        error: handleError,
    });
}

function getClientNameFromId(clientId) {
    return new Promise((resolve, reject) => {
        // Make an API call to retrieve client data based on the ID
        $.ajax({
            url: `/api/v1/clients/${clientId}`, // Adjust the URL based on your API endpoint
            headers: { Authorization: "Bearer " + token },
            method: "GET",
            success: function (response) {
                // Assuming the response contains the client name
                const clientName = response.data.attributes.name;
                resolve(clientName); // Resolve the promise with the client name
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error("Error fetching client name:", error);
                reject(error); // Reject the promise with the error
            },
        });
    });
}

// Function to fetch project details for update
export function fetchProjectDetailsForUpdate(projectId) {
    fetchClientsAndDisplayUpdateForm(projectId);
}

// Function to update project
function updateProject(projectId) {
    // Get the current form data
    const formData = {
        title: $("input[name='title']").val(),
        description: $("textarea[name='description']").val(),
        event_date: $("input[name='event_date']").val(),
        client_name: $("select[name='client_name']").val(),
        status: $("select[name='status']").val(),
    };

    // Fetch the original project data from the server
    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: function (response) {
            const project = response.data.attributes;

            // Compare the current form data with the original project data
            const formDataUnchanged =
                formData.title === project.title &&
                formData.description === project.description &&
                formData.event_date === project.event_date &&
                // formData.client_name === project.client_name &&
                formData.status === project.status;

            // If the form data hasn't changed, display an error message
            if (formDataUnchanged) {
                showMessage(
                    "error",
                    "No changes detected. Please make changes to update."
                );
                return; // Exit the function to prevent the AJAX request
            }

            // If the form data has changed, proceed with the update
            sendUpdateRequest(projectId, formData);
        },
        error: handleError,
    });
}

// Function to send the update request
function sendUpdateRequest(projectId, formData) {
    // Add CSRF token to formData
    formData._token = token;

    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
        },
        method: "PATCH",
        data: JSON.stringify(formData),
        success: function () {
            fetchProjectDetails(projectId);
            showMessage("success", "Project updated successfully.");
            console.log("Successfully updated"); // Fix the log here
        },
        error: handleError,
    });
}
