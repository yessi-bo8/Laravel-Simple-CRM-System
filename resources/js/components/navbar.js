document.addEventListener("DOMContentLoaded", function () {
    var menuToggle = document.getElementById("toggle-menu");
    var menuOptions = document.querySelector(".menu-options");

    menuToggle.addEventListener("click", function () {
        menuOptions.classList.toggle("expanded");
    });
});

console.log("app.js is loaded");
