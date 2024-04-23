import $ from "jquery";
import { fetchAllProjects } from "./index.js";
$(function () {
    // Check if the current URL path contains '/projects'
    if (window.location.pathname.includes("/projects")) {
        $("#banner-title").text("All Projects");
        fetchAllProjects();
    }
});
