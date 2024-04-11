import $ from "jquery";
import { token } from "../config.js";
import { showMessage } from "../message.js";
import { fetchAllProjects } from "./index.js";

// Function to delete project
export function deleteProject(projectId) {
    $.ajax({
        url: `/api/v1/projects/${projectId}`,
        headers: { Authorization: "Bearer " + token },
        method: "DELETE",
        success: function () {
            fetchAllProjects();
            showMessage("success", "Project deleted successfully.");
        },
        error: handleError,
    });
}

// Function to handle errors
function handleError(xhr, status, error) {
    console.error(error);
}
