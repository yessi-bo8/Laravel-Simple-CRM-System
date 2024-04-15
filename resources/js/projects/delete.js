import $ from "jquery";
import { token } from "../config.js";
import { showMessage } from "../message.js";
import { fetchAllProjects } from "./index.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

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
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });
}
