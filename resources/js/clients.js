import $ from "jquery";

$(document).ready(function () {
    const token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";

    // Function to fetch project details
    function fetchClientDetails(ClientId) {
        $.ajax({
            url: `/api/v1/clients/${ClientId}`,
            headers: { Authorization: "Bearer " + token },
            method: "GET",
            success: displayClientDetails,
            error: handleError,
        });
    }

    // Function to display project details
    function displayClientDetails(response) {
        const client = response.data.attributes;
        const relationships = response.data.relationships;

        let projectTitlesHTML = "";
        if (relationships["project titles"]) {
            const projectTitles = relationships["project titles"];
            projectTitles.forEach((title) => {
                projectTitlesHTML += `<p>${title}</p>`;
            });
        }

        const clientDetails = `
            <p>Title: ${client.name}</p>
            <p>Company: ${client.company}</p>
            <p>VAT: ${client.vat}</p>
            <p>Email: ${client.email}</p>
            </br>
            <p>Projects: ${relationships.project}</p>
            ${projectTitlesHTML}

            
            <button id="go-back-to-list">Go back to list</button>
        `;

        $("#client-details").html(clientDetails).show();
        $("#clients-list").hide();
        $("h1").text("Client info");

        $("#go-back-to-list").click(function () {
            $("#clients-list").show();
            $("#client-details").html("").hide();
            $("h1").text("All clients");
        });
    }

    // Function to handle errors
    function handleError(xhr, status, error) {
        console.error(error);
    }

    // Fetch projects using AJAX
    $.ajax({
        url: "/api/v1/clients",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayClients,
        error: handleError,
    });

    // Function to display projects
    function displayClients(response) {
        const clientsList = $("#clients-list");

        response.data.forEach(function (client) {
            const clientContainer = $("<div class='client-container'></div>");

            const clientLink = $("<a href='#'></a>")
                .text(client.attributes.name)
                .addClass("client-details-link")
                .data("client-id", client.id)
                .appendTo(clientContainer);

            clientsList.append(clientContainer);
        });

        $(".client-details-link").click(function (e) {
            e.preventDefault();
            fetchClientDetails($(this).data("client-id"));
        });
    }

    // Hide project details initially
    $("#client-details").hide();
});
