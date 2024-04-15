import $ from "jquery";
import { showMessage } from "../message.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

$(document).ready(function () {
    const token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";

    function fetchClientDetails(ClientId) {
        $.ajax({
            url: `/api/v1/clients/${ClientId}`,
            headers: { Authorization: "Bearer " + token },
            method: "GET",
            success: displayClientDetails,
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                showMessage("error", getErrorMessage(response));
                handleError;
            },
        });
    }

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

        $(".client-details").html(clientDetails).show();
        $(".client-containerr").hide();
        $("h1").text("Client info");

        $("#go-back-to-list").click(function () {
            $(".client-containerr").show();
            $(".client-details").html("").hide();
            $("h1").text("All clients");
        });
    }

    // Function to handle errors
    function handleError(xhr, status, error) {
        console.error(error);
    }

    $.ajax({
        url: "/api/v1/clients",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayClients,
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });

    function displayClients(response) {
        const clients = response.data;
        const clientsList = $(".client-container");

        clients.forEach(function (client) {
            const clientContainer = $("<div class='client-list'></div>");

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

    $(".client-details").hide();
});
