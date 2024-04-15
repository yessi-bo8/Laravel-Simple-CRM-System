import $ from "jquery";
import { fetchAllProjects } from "./projects/index.js";
$(function () {
    // Check if the current URL path contains '/projects'
    if (window.location.pathname.includes("/projects")) {
        fetchAllProjects();
    }
});
