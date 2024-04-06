import $ from "jquery";

$(document).ready(function () {
    var token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";

    // Function to fetch project details
    function fetchProjectDetails(projectId) {
        $.ajax({
            url: `/api/v1/projects/${projectId}`, // Fetch details of the specific project
            headers: {
                Authorization: "Bearer " + token,
            },
            method: "GET",
            success: function (response) {
                console.log(response); // Log the response to verify
                // Update project details dynamically
                $("#project-details")
                    .html(
                        `<p>${response.data.attributes.description}</p>
                    <button id="go-back-to-list">Go back to list</button>`
                    )
                    .show();
                $("#projects-list").hide(); // Hide the projects list
                $("h1").text("My project");
                // Event listener for "Go back to list" button
                $("#go-back-to-list").click(function () {
                    $("#projects-list").show(); // Show the projects list
                    $("#project-details").html("").hide(); // Clear and hide the project details
                    $("h1").text("All my projects"); // Reset the heading
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }

    // Fetch projects using AJAX
    $.ajax({
        url: "/api/v1/projects",
        headers: {
            Authorization: "Bearer " + token,
        },
        method: "GET",
        success: function (response) {
            // Iterate over the projects and render them in the view
            response.data.forEach(function (project) {
                // Create a container div for each project with padding
                var projectContainer = $(
                    "<div class='project-container'></div>"
                );

                // Append project details to the container div
                projectContainer.append(`
                    <p>Title: ${project.attributes.title}</p>
                    <p>Description: ${project.attributes.description}</p>
                    <p>Status: ${project.attributes.status}</p>
                    <p>User ID: ${project.relationships.id}</p>
                    <p>User Name: ${project.relationships["user name"]}</p>
                    <p>User Email: ${project.relationships["user email"]}</p>
                    <p>Client ID: ${project.relationships.id_client}</p>
                    <a href="#" class="project-details-link" data-project-id="${project.id}">Show more details</a>
                `);

                // Append the container div to the projects list
                $("#projects-list").append(projectContainer);
            });

            // Event listener for "show more details" links
            $(".project-details-link").click(function (e) {
                e.preventDefault();
                var projectId = $(this).data("project-id");
                fetchProjectDetails(projectId);
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
});
