import $ from "jquery";
import { token } from "../config.js";
import { handleError } from "../errors.js";
import { showMessage } from "../message.js";
import { fetchProjectDetails } from "./show.js";
import { getErrorMessage } from "../message.js";

// Function to fetch users and clients and display update form
function fetchUsersAndClientsAndDisplayUpdateForm(projectId) {
    $.when(
        $.ajax({
            url: "/api/v1/users",
            headers: { Authorization: "Bearer " + token },
            method: "GET",
        }),
        $.ajax({
            url: "/api/v1/clients",
            headers: { Authorization: "Bearer " + token },
            method: "GET",
        })
    )
        .done(function (usersResponse, clientsResponse) {
            const users = usersResponse[0].data;
            const clients = clientsResponse[0].data;

            // Generate user options
            const userOptions = users
                .map(
                    (user) =>
                        `<option value="${user.id}">${user.attributes.name}</option>`
                )
                .join("");

            // Generate client options
            const clientOptions = clients
                .map(
                    (client) =>
                        `<option value="${client.id}">${client.attributes.name}</option>`
                )
                .join("");

            // Show the update form
            displayUpdateForm(projectId, userOptions, clientOptions);
        })
        .fail(function (usersXHR, clientsXHR) {
            const usersResponse = usersXHR.responseJSON;
            const clientsResponse = clientsXHR.responseJSON;
            showMessage(
                "error",
                getErrorMessage(usersResponse || clientsResponse)
            );
            handleError;
        });
}

async function displayUpdateForm(projectId, userOptions, clientOptions) {
    // Now fetch project details
    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: async function (response) {
            const project = response.data.attributes;

            // Hide project details
            $(".project-container").empty();

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
        
                                    <label for="user_id">User:</label>
                                    <select name="user_id">
                                        ${userOptions}
                                    </select>
                                    <br />

                                    <label for="client_id">Client:</label>
                                    <select name="client_id">
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
            $(".project-container").append(updateForm);

            // Find the user ID corresponding to the project's user ID
            const userId = response.data.relationships.user_id;
            console.log(userId);

            // Set the default selected user in the select element
            $("select[name='user_id']").val(userId);

            // Find the client ID corresponding to the project's client ID
            const clientId = response.data.relationships.id_client;
            console.log(clientId);

            $("select[name='client_id']").val(clientId);

            // Add event listener for form submission
            $("#project-form").submit(function (event) {
                event.preventDefault(); // Prevent the default form submission
                updateProject(projectId); // Call the updateProject function
            });
        },
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}

// Function to fetch project details for update
export function fetchProjectDetailsForUpdate(projectId) {
    fetchUsersAndClientsAndDisplayUpdateForm(projectId);
}

// Function to update project
function updateProject(projectId) {
    // Get the current form data
    const formData = {
        title: $("input[name='title']").val(),
        description: $("textarea[name='description']").val(),
        event_date: $("input[name='event_date']").val(),
        client_id: $("select[name='client_id']").val(),
        user_id: $("select[name='user_id']").val(),
        status: $("select[name='status']").val(),
    };
    console.log("Data being sent to update:", formData);

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
                formData.client_id === response.data.relationships.id_client &&
                formData.user_id === response.data.relationships.user_id &&
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
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
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
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}
