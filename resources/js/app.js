// import "../css/app.css";
import $ from "jquery";
import "./config.js";
import "./projects/index.js";
import "./projects/create.js";
import "./projects/delete.js";
import "./projects/errors.js";
import "./projects/show.js";
import "./projects/update.js";
import "./projects.js";
import "./auth/login.js";
import "./auth/logout.js";
import "./auth/register.js";

import "./message.js";
import "./bootstrap";
import "./clients.js";
// import "./StoreProject.js";

// import { toggleSidebar } from "./functions";
document.addEventListener("DOMContentLoaded", function () {
    var menuToggle = document.getElementById("toggle-menu");
    var menuOptions = document.querySelector(".menu-options");

    menuToggle.addEventListener("click", function () {
        // Toggle the 'expanded' class on menuOptions
        menuOptions.classList.toggle("expanded");
    });
});

console.log("app.js is loaded");
