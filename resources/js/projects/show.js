import $ from "jquery";
import { token } from "../config.js";
import { handleError } from "./errors.js";
import { fetchProjectDetailsForUpdate } from "./update.js";
import { fetchAllProjects } from "./index.js";
// Function to fetch project details
export function fetchProjectDetails(projectId) {
    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayProjectDetails,
        error: handleError,
    });
}

// Function to display project details
function displayProjectDetails(response) {
    const project = response.data.attributes;
    const projectDetails = `
        <div class="task-container">
            <h2>${project.title}</h2>
            <hr>
            <div class="task-details">
                <p>Description: ${project.description}</p>
                <p>Event date: ${project.event_date}</p>
                <p>User id: ${response.data.relationships.id}</p>
                <p>Project id: ${response.data.id}</p>
                <p>Client: ${response.data.relationships.client_name}</p>
                <p>Assigned to User: ${response.data.relationships.user_name}</p>
                <button class="delete-project" data-project-id="${response.data.id}">Delete</button>
                <button class="update-project" data-project-id="${response.data.id}">Update</button>
                <button class="back-project">Back to Projects</button>
            </div>
        </div>
    `;

    $(".project-container").html(projectDetails);

    // Add event listener for delete project button
    $(".delete-project").click(function () {
        const projectId = $(this).data("project-id");
        deleteProject(projectId);
    });

    // Add event listener for update project button
    $(".update-project").click(function () {
        const projectId = $(this).data("project-id");
        fetchProjectDetailsForUpdate(projectId);
    });

    // Add event listener for update project button
    $(".back-project").click(function () {
        fetchAllProjects();
    });
}
