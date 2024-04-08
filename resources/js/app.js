// import "../css/app.css";
import "./bootstrap";
import "./projects.js";

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
