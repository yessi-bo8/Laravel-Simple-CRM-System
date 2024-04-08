import $ from "jquery";

$(document).ready(function () {
    const token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";

    // Function to fetch project details
    function fetchProjectDetails(projectId) {
        $.ajax({
            url: `/api/v1/projects/${projectId}`,
            headers: { Authorization: "Bearer " + token },
            method: "GET",
            success: displayProjectDetails,
            error: handleError,
        });
    }

    // Function to display project details
    function displayProjectDetails(response) {
        const project = response.data.attributes;
        const userId = response.data.relationships.id;
        const userName = response.data.relationships["user name"];
        const userEmail = response.data.relationships["user email"];
        const clientId = response.data.relationships.id_client;
        const RoleId = response.data.relationships.role_name;

        const projectDetails = `
            <p>Title: ${project.title}</p>
            <p>Description: ${project.description}</p>
            <p>Status: ${project.status}</p>
            <p>User ID: ${userId}</p>
            <p>User Name: ${userName}</p>
            <p>User Email: ${userEmail}</p>
            <p>Client ID: ${clientId}</p>
            <p>Role: ${RoleId}</p>
            <button id="go-back-to-list">Go back to list</button>
        `;

        $("#project-details").html(projectDetails).show();
        $("#projects-list").hide();
        $("h1").text("My project");

        $("#go-back-to-list").click(function () {
            $("#projects-list").show();
            $("#project-details").html("").hide();
            $("h1").text("All my projects");
        });
    }

    // Function to handle errors
    function handleError(xhr, status, error) {
        console.error(error);
    }

    // Fetch projects using AJAX
    $.ajax({
        url: "/api/v1/projects",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayProjects,
        error: handleError,
    });

    // Function to display projects
    function displayProjects(response) {
        const projectsList = $("#projects-list");

        response.data.forEach(function (project) {
            const projectContainer = $("<div class='project-container'></div>");

            const projectLink = $("<a href='#'></a>")
                .text(project.attributes.title)
                .addClass("project-details-link")
                .data("project-id", project.id)
                .appendTo(projectContainer);

            projectsList.append(projectContainer);
        });

        $(".project-details-link").click(function (e) {
            e.preventDefault();
            fetchProjectDetails($(this).data("project-id"));
        });
    }

    // Hide project details initially
    $("#project-details").hide();
});
