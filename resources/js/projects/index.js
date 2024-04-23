import $ from "jquery";
import { token } from "../config.js";
import { handleError } from "../errors.js";
import { fetchProjectDetails } from "./show.js";
import { deleteProject } from "./delete.js";
import { fetchProjectDetailsForUpdate } from "./update.js";
import { handleProjectCreation } from "./create.js";
import { showMessage } from "../message.js";
import { getErrorMessage } from "../message.js";

export function fetchAllProjects() {
    $.ajax({
        url: "/api/v1/projects",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayProjects,
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            console.log(response);
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}

// Function to display all projects
function displayProjects(response) {
    const projectsList = $(".project-container");
    projectsList.empty();

    const titleAndButton = $(`
        <button class="create-project">Create Project</button>
    `);
    projectsList.append(titleAndButton);

    response.data.forEach(function (project) {
        const projectList = $(`
            <div class='project-list'>
                <p class='project-name' data-project-id='${project.id}'>${project.attributes.title}</p>
                <button class='delete-project' data-project-id='${project.id}'>Delete</button>
                <button class='update-project' data-project-id='${project.id}'>Update</button>
            </div>
        `);

        projectsList.append(projectList);
    });

    // Add event listener for project name click
    $(".project-name").click(function () {
        const projectId = $(this).data("project-id");
        fetchProjectDetails(projectId);
    });

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
    $(".create-project").click(function () {
        handleProjectCreation();
    });
}
