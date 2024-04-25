import $ from "jquery";
import { token } from "../../config/config.js";
import { handleError } from "../../utils/errors.js";
import { fetchProjectDetailsForUpdate } from "./update.js";
import { fetchAllProjects } from "./index.js";
import { deleteProject } from "./delete.js";
import { showMessage } from "../../components/message.js";
import { getErrorMessage } from "../../components/message.js";

// Function to fetch project details
export function fetchProjectDetails(projectId) {
    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayProjectDetails,
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}

// Function to display project details
function displayProjectDetails(response) {
    const project = response.data.attributes;
    const projectDetails = `
        <div class="project-details">
            <div class="details-header">
                <h2>${project.title}</h2>
            </div>
            <div class="details-content">
                <p><strong>Description:</strong> ${project.description}</p>
                <p><strong>Status:</strong> ${project.status}</p>
                <p><strong>Event date:</strong> ${project.event_date}</p>
                <p><strong>Client:</strong> ${response.data.relationships.client_name}</p>
                <p><strong>Assigned to:</strong> ${response.data.relationships.user_name}</p>
            </div>
            <div class="details-footer">
                <button class="delete-project" data-project-id="${response.data.id}">Delete</button>
                <button class="update-project" data-project-id="${response.data.id}">Update</button>
                <button class="back-project">Back to Projects</button>
            </div>
        </div>
    `;

    $(".project-container").html(projectDetails);
    $("#banner-title").text("Current Project");

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
