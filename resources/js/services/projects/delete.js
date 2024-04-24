import $ from "jquery";
import { token } from "../../config/config.js";
import { showMessage } from "../../components/message.js";
import { getErrorMessage } from "../../components/message.js";
import { fetchAllProjects } from "./index.js";
import { handleError } from "../../utils/errors.js";

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
