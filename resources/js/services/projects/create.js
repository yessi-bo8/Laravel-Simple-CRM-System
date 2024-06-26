import $ from "jquery";
import { token } from "../../config/config.js";
import { showMessage } from "../../components/message.js";
import { getErrorMessage } from "../../components/message.js";
import { fetchProjectDetails } from "./show.js";
import { handleError } from "../../utils/errors.js";

export function handleProjectCreation() {
    let clientOptions = "";
    let userOptions = "";

    // Load clients, users, and tasks concurrently
    const clientsRequest = $.ajax({
        url: "/api/v1/clients",
        headers: { Authorization: "Bearer " + token },
    });

    const usersRequest = $.ajax({
        url: "/api/v1/users",
        headers: { Authorization: "Bearer " + token },
    });

    $.when(clientsRequest, usersRequest)
        .done((clientsResponse, usersResponse) => {
            // Process clients data
            const clients = clientsResponse[0].data;
            clientOptions = clients
                .map(
                    (client) =>
                        `<option value="${client.id}">${client.attributes.name}</option>`
                )
                .join("");

            // Process users data
            const users = usersResponse[0].data;
            userOptions = users
                .map(
                    (user) =>
                        `<option value="${user.id}">${user.attributes.name}</option>`
                )
                .join("");
            console.log("User Options:", userOptions);

            // Show form after all data is loaded
            showForm();
            $("#banner-title").text("Create Project");
        })
        .fail((error) => {
            console.error("Error loading data:", error);
            showMessage("error", getErrorMessage(error.responseJSON));
        });

    // Function to show the form after clients, users, and tasks are loaded
    function showForm() {
        $(".project-container").html(`
            <div class="form-container" >
                <form id="create-project-form" method="POST">
                    <label>Title:</label>
                    <input type="text" name="title" required>
                    <div id="title-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for title -->
                    <br />

                    <label for="description">Description:</label>
                    <textarea name="description" rows="4" cols="50" required></textarea>
                    <div id="description-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for description -->
                    <br />
        
                    <label>Date deadline:</label>
                    <input type="date" name="event_date"required>
                    <div id="event_date-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for event_date -->
                    <br />
        
                    <label for="user_id">Assignee:</label>
                    <select name="user_id" required>
                        <option value="">Select User</option>
                        ${userOptions}
                    </select>
                    <div id="user_id-error" class="alert alert-danger form_danger" style="display: none;"></div> <!-- Error container for user_id -->
                    <br />

                    <label for="client_id">Client:</label>
                    <select name="client_id" required>
                        <option value="">Select Client</option>
                        ${clientOptions} 
                    </select>
                    <div id="client_id-error" class="alert alert-danger form_danger" style="display: none;"></div>
                    <br />

                    <label for="status">Status:</label>
                        <select name="status" required>
                            <option value="">Select Status</option>
                            <option value="approved">approved</option>
                            <option value="pending">pending</option>
                            <option value="rejected">rejected</option>
                        </select>
                        <div id="status-error" class="alert alert-danger form_danger" style="display: none;"></div>
                        </br >

                    <button type="submit" class="create-button">Make new Project</button>
                </form>
            </div>
        `);
    }

    // Handle form submission
    $(document).on("submit", "#create-project-form", function (event) {
        event.preventDefault();

        // Convert form data array to JSON object
        const formData = $(this).serializeArray();
        const jsonData = {};
        formData.forEach((field) => {
            jsonData[field.name] = field.value;
        });

        console.log("JSON Data:", jsonData);

        $.ajax({
            url: "/api/v1/projects",
            method: "POST",
            contentType: "application/json",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/vnd.api+json",
                Accept: "application/vnd.api+json",
            },
            data: JSON.stringify(jsonData),
            success: function (response) {
                const projectId = response.data.id;
                console.log("Project created successfully:", response);
                fetchProjectDetails(projectId);
                showMessage("success", "Project created successfully.");
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                showMessage("error", getErrorMessage(response));
                handleError;
            },
        });
    });
}
